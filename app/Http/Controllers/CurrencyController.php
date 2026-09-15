<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __invoke(Request $request, CurrencyService $currency)
    {
        $request->validate([
            'currency' => ['required', 'string', 'in:USD,EUR,INR,CNY,JPY'],
        ]);

        $currency->set($request->input('currency'));

        return back();
    }
}
