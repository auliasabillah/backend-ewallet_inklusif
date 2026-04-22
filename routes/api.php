<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/logi', function (Request $request) {
    $email = $request->email;
    $password = $request->password;

    return response()->json([
        'email' => $email,
        'password' => $password
    ]);
});

Route::get('/test', function () {
    return "HELLO";
});