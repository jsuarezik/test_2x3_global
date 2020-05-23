<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Validator;

class PaymentController extends Controller
{
    public function all(Request $request) {
        $query = Payment::query();

        $result = $query->ofClient(request('client', null))->get();

        return response()->json($result, 200);
    }

    public function add(Request $request)
    {
        $rules = Payment::rules()['create'];
        $validator = Validator::make($request->all(), $rules); 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result = Payment::create($request->all());

        if ($result) {
            return response()->json($result, 201);
        } 

        return response()->json('Unexpected Error', 500);
    }
}
