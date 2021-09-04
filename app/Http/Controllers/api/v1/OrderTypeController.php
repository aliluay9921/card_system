<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    public function index()
    {
        return response()->json(['types' => OrderType::where('active', 1)->get()], 200);
    }
}