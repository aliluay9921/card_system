<?php

namespace App\Http\Controllers;

use App\Notifications\BalanceUpdate;
use App\Order;
use App\OrderType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cards.order.index');
    }


    public function dataTable()
    {
        $orders = Order::with('type', 'user');
        return Datatables::of($orders)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })->editColumn('value', function ($data) {
                return number_format($data->value);
            })->addColumn('action', function ($row) {
                return "<a class='btn btn-info text-white'  onclick='approve( $row->id )' class='py-2'>تاكيد</a>";
            })->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, Order $order)
    {
        if ($order->approved_at) {
            $request->session()->flash('error', 'تمت عمليه تاكيد هذا الطلب مسبقا');
            return response('تمت اضافه الرصيد بنجاح', 200);
        }

        $order->approved_at = now();
        $order->admin_id = Auth::id();
        $order->save();

        $balance = $order->user->balance;
        $user = User::find($order->user_id);
        $user->balance = $balance + $order->value;
        $user->save();

        $test = OrderType::find($order->type_id);

        $test->transfer()->create([
            'user_id' => Auth::id(),
            'before' => $balance,
            'after' => $user->balance,
            'points' => $order->value * 0.05,
            'key' => '',
            'amount' => $order->value,
            'transfer_out' => 1,
            'created_at' => now(),
        ]);
        $title = "تحديث رصيد حسابك";
        $body = "تم تاكيد الحوالة واضافه الرصيد";

        $user->notify(new BalanceUpdate($title, $body));


        $request->session()->flash('status', 'تمت اضافه الرصيد بنجاح!');
        return response('تمت اضافه الرصيد بنجاح', 200);
    }


    public function destroy(Order $order)
    {
        //
    }
}
