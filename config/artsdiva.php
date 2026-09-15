<?php

return [

    'name' => 'ArtsDiva',

    'tagline' => 'Fine art acquisition and annual leasing',

    'inquiry_email' => env('ARTSDIVA_INQUIRY_EMAIL', 'inquiries@artsdiva.com'),

    /*
    |--------------------------------------------------------------------------
    | Currency rates relative to EUR (base)
    |--------------------------------------------------------------------------
    | Approximate display rates for the public catalogue.
    | Update when live FX feed is available.
    */
    'currencies' => [
        'EUR' => ['label' => 'Euros', 'symbol' => '€', 'rate' => 1.0],
        'USD' => ['label' => 'US Dollars', 'symbol' => '$', 'rate' => 1.08],
        'INR' => ['label' => 'Indian Rupees', 'symbol' => '₹', 'rate' => 90.0],
        'CNY' => ['label' => 'Chinese Yuan', 'symbol' => '¥', 'rate' => 7.8],
        'JPY' => ['label' => 'Japanese Yen', 'symbol' => '¥', 'rate' => 163.0],
    ],

    'default_currency' => 'EUR',

    /*
    |--------------------------------------------------------------------------
    | Annual leasing rate tiers (based on EUR acquisition value)
    |--------------------------------------------------------------------------
    | Brief: under €25,000 is 10% per annum, scaling down for higher value.
    | Intermediate tiers assumed pending client confirmation.
    */
    'lease_tiers' => [
        ['max' => 25000, 'rate' => 0.10, 'label' => '10%'],
        ['max' => 50000, 'rate' => 0.08, 'label' => '8%'],
        ['max' => 100000, 'rate' => 0.065, 'label' => '6.5%'],
        ['max' => null, 'rate' => 0.05, 'label' => '5%'],
    ],

];
