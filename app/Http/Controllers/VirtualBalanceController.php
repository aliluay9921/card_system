<?php

namespace App\Http\Controllers;

use App\Notifications\BalanceUpdate;
use App\User;
use App\VirtualBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class VirtualBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cards.virtualBalance.index');

    }

    function dataTable()
    {
        $cards = VirtualBalance::with('user', 'created_by');
        return Datatables::of($cards)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })
            ->editColumn('amount', function ($data) {
                return number_format($data->amount);
            })->editColumn('before', function ($data) {
                return number_format($data->before);
            })
            ->editColumn('after', function ($data) {
                return number_format($data->after);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.virtualBalance.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'amount' => 'required',
                'user_id' => 'required|exists:users,id',
            ], [
                'amount.required' => 'يرجى ادخال قيمه',
                'user_id.required' => 'يرجى اختيار مستلم الرصيد',
                'user_id.exists' => 'حدث خطا اعد العمليه',
            ]
        );

        if ($validation->fails()) {
            $request->session()->flash('error', $validation->errors()->first());
            return response($validation->errors()->first(), 422);
        }

        $user = User::find($request->user_id);

        $after = $user->balance + $request->amount;

        VirtualBalance::create([
            'user_id' => $user->id,
            'before' => $user->balance,
            'after' => $after,
            'amount' => $request->amount,
            'created_by_id' => Auth::id(),
            'created_at' => now(),
        ]);


        $admin = User::find(Auth::id());


        $admin->transfer()->create([
            'user_id' => $user->id,
            'before' => $user->balance,
            'after' => $after,
            'points' => 0,
            'key' => NULL,
            'transfer_out' => 0,
            'amount' => $request->amount,
            'created_at' => now(),
        ]);

//        $user->transfer()->create([
//            'user_id' => $admin->id,
//            'before' => $admin->balance,
//            'after' => $admin->balance - $request->amount,
//            'points' => 0,
//            'key' => NULL,
//            'amount' => $request->amount,
//            'created_at' => now(),
//        ]);

        $admin->balance = $admin->balance - $request->amount;
        $admin->save();

        $user->balance = $after;
        $user->save();
        $title = "استلام رصيد";

        $body = "تم اضافه $request->amount دينار عراقي الى رصيد حسابك";

        $user->notify(new BalanceUpdate($title, $body));

        $request->session()->flash('status', 'تمت اضافه الرصيد بنجاح!');
        return response('تمت اضافه الرصيد بنجاح', 200);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\VirtualBalance $virtualBalance
     * @return \Illuminate\Http\Response
     */
    public function show(VirtualBalance $virtualBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\VirtualBalance $virtualBalance
     * @return \Illuminate\Http\Response
     */
    public function edit(VirtualBalance $virtualBalance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\VirtualBalance $virtualBalance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VirtualBalance $virtualBalance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\VirtualBalance $virtualBalance
     * @return \Illuminate\Http\Response
     */
    public function destroy(VirtualBalance $virtualBalance)
    {
        //
    }
}
