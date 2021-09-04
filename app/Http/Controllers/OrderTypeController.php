<?php

namespace App\Http\Controllers;

use App\OrderType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;


class OrderTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_orders = OrderType::all();
        return view('cards.order.typeOrders', compact('type_orders'));
    }

    public function activeOrderType(Request $request)
    {
        $order_type = OrderType::find($request->id);

        $order_type->update([
            'active' => !$order_type->active
        ]);
        $request->session()->flash('status', 'تم التعديل بنجاح');
        return response()->json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح',
            'id' =>  $request->id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.order.orderTypeCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:order_types,name',
                'name_ar' => 'required|unique:order_types,name_ar',
                'phone_number' => 'required|numeric',
                'active' => 'required'
            ],
            [
                'name.required' => 'يرجى ادخال اسم ',
                'name.unique' => 'تم حفظ هذه الخدمه من قبل ',
                'name_ar.unique' => 'تم حفظ هذه الخدمه من قبل',
                'name_ar.required' => 'يرجى اختيار  اسم العربي',
                'phone_number.required' => 'يرجى ادخال الرابط رقم الهاتف ',
                'phone_number.numeric' => 'يرجى ادخال رقم هاتف صالح للأستخدام',
                'active.required' => 'يرجى اختيار نوع التفعيل '
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        OrderType::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'phone_number' => $request->phone_number,
            'active' => $request->active
        ]);

        return   redirect()->route('order_type.index')->with('status', 'تم اضافة عنصر جديد');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function show(OrderType $orderType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderType $orderType)
    {
        // $users = User::whereNotNull('activate_at')->get();
        // $ad_users = Ads_user::where('ads_id', $ad->id)->pluck('user_id')->toArray();

        // return view('cards.ads.edit', compact('ad', 'users', 'ad_users'));
        $order_type = OrderType::find($orderType);
        return view('cards.order.orderTypeEdit', compact('order_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderType $orderType)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'name_ar' => 'required ',
                'phone_number' => 'required|numeric',
            ],
            [
                'name.required' => 'يرجى ادخال اسم ',
                'name_ar.required' => 'يرجى اختيار  اسم العربي',
                'phone_number.required' => 'يرجى ادخال الرابط رقم الهاتف ',
                'phone_number.numeric' => 'يرجى ادخال رقم هاتف صالح للأستخدام',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        OrderType::find($request->id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'phone_number' => $request->phone_number
        ]);
        return back()->with('status', 'تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderType $orderType)
    {
        //
    }
}