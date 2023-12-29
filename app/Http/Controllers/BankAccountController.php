<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Investments;
use App\Models\InvestmentsAccounts;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{

    public function view()
    {
        $accounts = BankAccount::where('user_id', auth()->id())->get();
        $investmentAccounts = InvestmentsAccounts::where('user_id', auth()->id())->get();

        return view('my-accounts.index', compact('accounts', 'investmentAccounts'));
    }

    public function create()
    {
        return view('my-accounts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'currency' => 'required|in:EUR,GBP,USD',
            'balance' => 'required|numeric',
        ]);

        $data['user_id'] = auth()->id();
        $data['balance'] = (int)($data['balance'] * 100); // Convert to cents

        BankAccount::create($data);

        return redirect()->route('my-accounts')->with('success', 'New account created!');
    }

    public function delete(Request $request)
    {
        $account = BankAccount::where('account_no', $request->account_no)->first()
            ?? InvestmentsAccounts::where('account_no', $request->account_no)->first();

        if (!$account) {
            return back()->withErrors(['msg' => 'Account not found.']);
        }


        if ($account->balance > 0) {
            return back()->withErrors(['msg' => 'Before deleting the account, transfer funds to another account.']);
        }

        if ($account instanceof InvestmentsAccounts) {
            $activeInvestments = Investments::where('user_id', auth()->id())
                ->where('status', 'Active')
                ->exists();

            if ($activeInvestments) {
                return back()->withErrors(['msg' => 'While you have active investments, you can\'t delete the Investment account.']);
            }
        }

        $account->delete();

        return redirect()->route('my-accounts')->with('success', 'Account deleted successfully.');
    }
}
