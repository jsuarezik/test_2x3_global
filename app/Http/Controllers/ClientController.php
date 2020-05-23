<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function all(Request $request) {
        $result = \App\Client::all();
        return response()->json($result, 200);
    } 

}
