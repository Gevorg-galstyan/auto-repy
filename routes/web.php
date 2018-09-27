<?php

use App\Services\Quick;
use Illuminate\Http\Request;

Route::post('/', function (Request $request, Quick $quick) {
    $quick->run($request->all());
});

Route::get('/', function (Request $request) {
    if (!(bool) env('FACEBOOK_VERIFIED')) {
        if ($request->get('hub_verify_token') == env('FACEBOOK_SECRET')) {
            return $_GET['hub_challenge'];
        }
    }
});
