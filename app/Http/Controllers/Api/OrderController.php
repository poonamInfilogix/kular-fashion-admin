<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    function PosOrderPlace(Request $request){
        return $request;
    }
    public function testOutsideAuth()
    {
        return response()->json(['message' => 'This is accessible without authentication']);
    }
}
