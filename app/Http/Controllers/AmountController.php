<?php

namespace App\Http\Controllers;

use App\Amount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amounts = Amount::all();
        return view('cards.amount.index', compact('amounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.amount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'value' => 'required',
                'active' => 'required',
                'price' => 'required'
            ],
            [
                'value.required' => 'يرجى ادخال قيمه البطاقه',
                'active.required' => 'يرجى ادخال حاله البطاقه',
                'price.required' => 'يرجى ادخال سعر البطاقه',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        Amount::create([
            'value' => $request->value,
            'active' => $request->active,
            'price' => $request->price,
            'created_at' => now(),
        ]);

        $request->session()->flash('status', "تمت الاضافه بنجاح");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Amount $amount
     * @return \Illuminate\Http\Response
     */
    public function show(Amount $amount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Amount $amount
     * @return \Illuminate\Http\Response
     */
    public function edit(Amount $amount)
    {
        return view('cards.amount.edit', compact('amount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Amount $amount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amount $amount)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'value' => 'required',
                'active' => 'required',
                'price' => 'required'

            ],
            [
                'value.required' => 'يرجى ادخال قيمه البطاقه ',
                'active.required' => 'يرجى ادخال حاله البطاقه',
                'price.required' => 'يرجى ادخال سعر البطاقه',


            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $amount->value = $request->value;
        $amount->active = $request->active;
        $amount->price = $request->price;
        $amount->updated_at = now();
        $amount->save();

        $request->session()->flash('status', "تم التعديل بنجاح");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Amount $amount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amount $amount)
    {
        //
    }
}