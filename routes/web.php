<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    \App\Models\User::all(); // duplicate query example
    \App\Models\User::all(); // duplicate query example
    \App\Models\User::all();

    $firstUser = \App\Models\User::first();
    // teste 1,2

    $myString = 'Hello World!';

    $myArray = ['name' => 'Luan', 'country' => 'BR'];

    $myBoolean = false;

    //Single value
    ds($myString);

    //Multiple values
    ds($myString, $myArray, $myBoolean);

    ds('Hello world!');

    // Requires Auto-Invoke to be enabled

    $products = [['id' => 1, 'price' => 10], ['id' => 2, 'price' => 50], ['id' => 3, 'price' => -5]];

    foreach ($products as $product) {
        dsq('Checking product #'.$product['id']); //Send a dump without invoking the app

        if ($product['price'] < 0) {
            ds('Price error in product #'.$product['id']); //App will be invoked
        }
    }

    $person = ['name' => 'Luan', 'country' => 'BR'];
    $person2 = ['name' => 'Taylor', 'country' => 'US'];

    ds($person)->label('Creator of Laradumps');

    ds($person2)->label('Creator of Laravel');

    ds('this is screen 1'); //default screen

    ds('this is screen 2')->toScreen('screen 2');

    ds('custom value')->s('Custom screen');

    ds('Info: Just FYI')->info(); // or ->blue()

    ds('Success: IT WORKS!')->success(); // or ->green()

    ds('Danger: ERROR!!!')->danger(); // or ->red()

    ds('Warning: Something is not right!')->warning(); // or ->orange()

    ds('Dark: The Dark Side of the Moon')->dark(); // or ->black()

    // Using an iterable
    $allUsers = [
        ['id' => 1, 'name' => 'David', 'email' => 'david@example.com'],
        ['id' => 2, 'name' => 'Julia', 'email' => 'julia@example.com'],
        //...
    ];

    // Using Eloquent
    $allUsers = User::all(['id', 'name', 'email']);

    ds()->table($allUsers, 'my users table');

    return view('welcome');
});
