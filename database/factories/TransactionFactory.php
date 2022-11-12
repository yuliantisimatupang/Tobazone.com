<?php

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'customer_id' => 3,
        'merchant_id' => 2,
        'address' => 'Customer, 08123 Simpang Empat Laguboti, Laguboti, Toba Samosir, Sumatera Utara (22316)',
        'status' => 'pending',
        'courier' => 'tiki',
    ];
});
