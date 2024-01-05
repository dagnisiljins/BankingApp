<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Investments;
use App\Models\InvestmentsAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvestmentsController extends Controller
{
    public function view(): Response
    {
        $investmentAccount = InvestmentsAccounts::where('user_id', auth()->id())->first();

        $activeInvestments = Investments::where('user_id', auth()->id())
            ->where('status', 'Active')
            ->get();
        $soldInvestments = Investments::where('user_id', auth()->id())
            ->where('status', 'Sold')
            ->get();

        // Fetch the latest rates for each cryptocurrency in the investments
        $cryptoRates = Crypto::whereIn('crypto_symbol', $activeInvestments->pluck('crypto_symbol'))->get()->keyBy('crypto_symbol');

        // Add current value and percentage change to each investment
        foreach ($activeInvestments as $activeInvestment) {
            $currentRate = $cryptoRates[$activeInvestment->crypto_symbol]->EUR;
            $activeInvestment->currentValue = $activeInvestment->quantity * $currentRate;
            $activeInvestment->purchaseValue = $activeInvestment->quantity * $activeInvestment->purchase_rate;
            $activeInvestment->percentageChange = (($activeInvestment->currentValue - $activeInvestment->purchaseValue) / $activeInvestment->purchaseValue) * 100;
        }
        foreach ($soldInvestments as $soldInvestment) {
            $soldInvestment->saleValue = $soldInvestment->sale_value / 100;
            $soldInvestment->purchaseValue = $soldInvestment->quantity * $soldInvestment->purchase_rate;
            $soldInvestment->percentageChange = (($soldInvestment->saleValue - $soldInvestment->purchaseValue) / $soldInvestment->purchaseValue) * 100;
        }


        return response()->view('investments.index', compact('activeInvestments', 'soldInvestments', 'investmentAccount'));
    }

    public function create()
    {
        if (!InvestmentsAccounts::where('user_id', auth()->id())->first()) {

            return redirect()->route('investments')->with('error', 'You need to create investment account!');
        }

        $cryptoRates = Crypto::whereIn('crypto_symbol', ['BTC', 'ETH', 'LTC'])->get();

        return response()->view('investments.create', compact('cryptoRates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'crypto_symbol' => 'required',
            'quantity' => 'required|integer',
        ]);

        $cryptoRate = Crypto::where('crypto_symbol', $request->crypto_symbol)->first();
        if (!$cryptoRate) {
            return back()->withErrors(['msg' => 'Crypto rate not found']);
        }

        $currentRate = $cryptoRate->EUR;
        $amount = $request->quantity * $currentRate;

        $investmentAccount = InvestmentsAccounts::where('user_id', auth()->id())->first();
        if (!$investmentAccount) {
            return back()->withErrors(['msg' => 'Investment account not found']);
        }

        if ($investmentAccount->balance < round($amount * 100)) {
            return redirect()->route('investments')->with('error', 'You dont have enough funds to make this investment!');
        }

        $investmentAccount->balance -= round($amount * 100);
        $investmentAccount->save();

        $data = [
            'user_id' => auth()->id(),
            'crypto_symbol' => $request->crypto_symbol,
            'quantity' => $request->quantity,
            'purchase_rate' => $currentRate,
            'status' => 'Active',
        ];

        Investments::create($data);


        return redirect()->route('investments')->with('success', 'You have a new investment!');
    }

    public function sell(Request $request): RedirectResponse
    {
        $request->validate([
            'investment_ID' => 'required|integer',
        ]);

        $investment = Investments::where('id', $request->investment_ID)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cryptoRate = Crypto::where('crypto_symbol', $investment->crypto_symbol)->first();
        if (!$cryptoRate) {
            return back()->withErrors(['msg' => 'Crypto rate not found']);
        }

        $currentRate = $cryptoRate->EUR;
        $amount = $investment->quantity * $currentRate;

        $investmentAccount = InvestmentsAccounts::where('user_id', auth()->id())->first();
        if (!$investmentAccount) {
            return back()->withErrors(['msg' => 'Investment account not found']);
        }

        $investmentAccount->balance += round($amount * 100);
        $investmentAccount->save();

        $investment->status = 'Sold';
        $investment->sale_value = round($amount * 100);
        $investment->save();

        return redirect()->route('investments')->with('success', 'Sale of investment completed successfully');
    }
}
