<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{

    public function view()
    {
        $accounts = BankAccount::where('user_id', auth()->id())->get();
        return view('my-accounts.index', compact('accounts'));
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
}
