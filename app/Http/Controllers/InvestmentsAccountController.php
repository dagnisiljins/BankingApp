<?php

namespace App\Http\Controllers;

use App\Models\InvestmentsAccounts;
use Illuminate\Http\RedirectResponse;

class InvestmentsAccountController extends Controller
{
    public function create(): RedirectResponse
    {

        $data['user_id'] = auth()->id();
        $data['balance'] = 0;

        InvestmentsAccounts::create($data);

        return redirect()->route('investments')->with('success', 'New investment account created!');
    }
}
