<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{


    public function index()
    {
        return response()->json(['orders' => Order::where('user_id', Auth::id())->with('type')->get()], 200);
    }


    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'value' => 'required|numeric',
                'type' => 'required|exists:order_types,id',
                'phone' => 'required',
            ],
            [
                'value.required' => 'يرجى ادخال قيمه',
                'value.numeric' => 'يرجى التحقق من القيمه',
                'type.required' => 'يرجى اختيار نوع',
                'type.exists' => 'يرجى التحقق من نوع العمليه',
                'phone.required' => 'يرجى ادخال رقم الهاتف'
            ]
        );

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->first()], 404);
        }
        $types = OrderType::find($request->type);

        Order::create([
            'user_id' => Auth::id(),
            'value' => $request->value,
            'type_id' => $request->type,
            'phone_hawala' => $types->phone_number,
            'phone' => $request->phone,
            'created_at' => now(),
        ]);
        return response()->json(['error' => 'تم اضافه الطلب بنجاح'], 200);
    }

    public function show($id)
    {
        return response()->json(['order' => Order::find($id)], 200);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}