<?php

namespace App\Http\Controllers\api\v1;

use App\Amount;
use App\Http\Controllers\Controller;

class AmountController extends Controller
{
    public function index()
    {
        $amounts = Amount::all();
        return compact('amounts');
    }
}
