<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transfers;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransfersController extends Controller
{
    public function view()
    {
        $accounts = BankAccount::where('user_id', auth()->id())->get();
        return view('transfers.index', compact('accounts'));
    }

    public function create()
    {
        return view('transfers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'senders_account' => 'required',
            'recipient_account' => 'required',
            'amount' => 'required|numeric|min:0.01', // Ensure amount is numeric and at least 0.01
            'reference' => 'required'
        ]);

        $senderAccount = BankAccount::findOrFail($request->senders_account);
        $recipientAccount = BankAccount::findOrFail($request->recipient_account);
        $transferAmount = $request->amount * 100; // Convert to cents


        if ($senderAccount->balance < $transferAmount) {
            return back()->withErrors(['msg' => 'Insufficient funds']);
        }

        DB::transaction(function () use ($senderAccount, $recipientAccount, $transferAmount, $request) {
            $senderAccount->balance -= $transferAmount;
            $senderAccount->save();


            if ($senderAccount->currency != $recipientAccount->currency) {
                // Get exchange rates
                $senderRate = $senderAccount->currency == 'EUR' ? 1 : Currency::where('symbol', $senderAccount->currency)->first()->rate;
                $recipientRate = $recipientAccount->currency == 'EUR' ? 1 : Currency::where('symbol', $recipientAccount->currency)->first()->rate;

                // Convert sender currency to EUR (if needed), then to recipient currency
                $transferAmountInEUR = $transferAmount / $senderRate;
                $transferAmount = $transferAmountInEUR * $recipientRate;
            }

            $recipientAccount->balance += $transferAmount;
            $recipientAccount->save();

            // Record the transaction
            $initialTransferAmount = $request->amount * 100; //To track initial amount

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

        return redirect()->route('dashboard')->with('success', 'Transfer completed successfully');
    }

    public function history(Request $request)
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

        return view('transfers.history',
            compact('transfers', 'totalSent', 'totalReceived', 'accountNo'));
    }

}
