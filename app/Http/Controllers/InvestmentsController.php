<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Investments;
use Illuminate\Http\Request;

class InvestmentsController extends Controller
{
    public function view()
    {
        $investments = Investments::where('user_id', auth()->id())->get();

        // Fetch the latest rates for each cryptocurrency in the investments
        $cryptoRates = Crypto::whereIn('crypto_symbol', $investments->pluck('crypto_symbol'))->get()->keyBy('crypto_symbol');

        // Add current value and percentage change to each investment
        foreach ($investments as $investment) {
            $currentRate = $cryptoRates[$investment->crypto_symbol]->EUR;
            $investment->currentValue = $investment->quantity * $currentRate;
            $investment->purchaseValue = $investment->quantity * $investment->purchase_rate;
            $investment->percentageChange = (($investment->currentValue - $investment->purchaseValue) / $investment->purchaseValue) * 100;
        }

        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        return view('investments.create');
    }

    public function store(Request $request)
    {
        //TODO add logic
    }

    public function sell(Request $request)
    {
        echo 'Sorry! We are still building this option.';
    }
}
