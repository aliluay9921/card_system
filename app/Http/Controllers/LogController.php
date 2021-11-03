<?php

namespace App\Http\Controllers;

use App\CahrgeBalance;
use App\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogController extends Controller
{
    public function index()
    {

        return view('cards.log.index');
    }
    public function getChargeReport()
    {
        return view('cards.log.chargeReport');
    }
    function dataTableChargeReport()
    {
        $charge_balance = CahrgeBalance::with('user');
        return Datatables::of($charge_balance)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })->make(true);
    }

    function dataTable()
    {


        $cards = Log::with('user', 'transfer', 'card.amount');

        return Datatables::of($cards)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })->editColumn('card.sale_price', function ($data) {
                return $data->card ? number_format($data->card->sale_price) : $data->amount;
            })->addColumn('type', function ($row) {
                if ($row->transfer_type == "App\\User") {
                    return "تحويل رصيد";
                } elseif ($row->transfer_type == "App\\OrderType") {
                    return "حواله";
                } elseif ($row->transfer_type == "App\\Company") {
                    return "شراء كارتات";
                }
            })->addColumn('transfer_to', function ($row) {
                if ($row->transfer_type == "App\\User") {
                    return $row->user->name;
                }
            })->addColumn('card_amount', function ($row) {
                if ($row->card) {
                    return $row->card->amount->value;
                }
            })->addColumn('card_id', function ($row) {
                if ($row->card) {
                    return $row->card->id;
                }
            })->addColumn('company_name', function ($row) {
                if (empty($row->transfer->name)) {
                    return 'محذوفة';
                } else {
                    if ($row->transfer_type == "App\\Company") {
                        return $row->transfer->name;
                    }
                }
                if ($row->transfer_type == "App\\OrderType") {
                    return $row->transfer->name;
                }
            })->addColumn('transfer_to_phone', function ($row) {
                if ($row->transfer_type == "App\\User") {
                    return $row->user->phone;
                }
            })->make(true);
    }

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
     * @param \App\Log $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Log $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Log $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Log $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}