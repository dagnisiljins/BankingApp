<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\InvestmentsAccounts;
use App\Models\Transfers;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransfersController extends Controller
{
    public function view(): Response
    {
        $accounts = BankAccount::where('user_id', auth()->id())->get();
        $investmentAccounts = InvestmentsAccounts::where('user_id', auth()->id())->first();

        return response()->view('transfers.index', compact('accounts', 'investmentAccounts'));
    }

    public function create(): Response
    {
        return response()->view('transfers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'senders_account' => 'required',
            'recipient_account' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'required'
        ]);


        $senderAccount = BankAccount::where('account_no', $request->senders_account)->first()
            ?? InvestmentsAccounts::where('account_no', $request->senders_account)->first();
        $recipientAccount = BankAccount::where('account_no', $request->recipient_account)->first()
            ?? InvestmentsAccounts::where('account_no', $request->recipient_account)->first();

        $transferAmount = $request->amount * 100; // Convert to cents

        if (!$senderAccount || !$recipientAccount) {
            return back()->withErrors(['msg' => 'One or both account numbers are invalid.']);
        }

        if ($senderAccount->balance < $transferAmount) {
            return back()->withErrors(['msg' => 'Insufficient funds']);
        }

        DB::transaction(function () use ($senderAccount, $recipientAccount, $transferAmount, $request) {
            $senderAccount->balance -= $transferAmount;
            $senderAccount->save();


            if ($senderAccount->currency != $recipientAccount->currency) {
                $senderRate = $senderAccount->currency == 'EUR' ? 1 : Currency::where('symbol', $senderAccount->currency)->first()->rate;
                $recipientRate = $recipientAccount->currency == 'EUR' ? 1 : Currency::where('symbol', $recipientAccount->currency)->first()->rate;

                $transferAmountInEUR = $transferAmount / $senderRate;
                $transferAmount = $transferAmountInEUR * $recipientRate;
            }

            $recipientAccount->balance += $transferAmount;
            $recipientAccount->save();

            $initialTransferAmount = $request->amount * 100;

            Transfers::create([
                'from_account' => $senderAccount->account_no,
                'to_account' => $recipientAccount->account_no,
                'sent_amount' => $initialTransferAmount,
                'received_amount' => $transferAmount,
                'sent_currency' => $senderAccount->currency,
                'received_currency' => $recipientAccount->currency,
                'payment_reference' => $request->reference
            ]);
        });

        return redirect()->route('transfers')->with('success', 'Transfer completed successfully');
    }

    public function history(Request $request): Response
    {
        $accountNo = $request->query('account');
        $transfers = Transfers::where('from_account', $accountNo)
            ->orWhere('to_account', $accountNo)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Get 10 records per page

        $totalSent = Transfers::where('from_account', $accountNo)
            ->sum('sent_amount');

        $totalReceived = Transfers::where('to_account', $accountNo)
            ->sum('received_amount');

        return response()->view('transfers.history',
            compact('transfers', 'totalSent', 'totalReceived', 'accountNo'));
    }

}
