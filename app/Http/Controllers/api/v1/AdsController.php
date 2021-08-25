<?php

namespace App\Http\Controllers\api\v1;

use App\Ads;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdsController extends Controller
{

    public function index()
    {
        $ads = Ads::where('active', 1)->
        whereHas('user', function ($q) {
            $q->where('user_id', Auth::id());
        })->orwhere('public', 1)->where('active', 1)
            ->get();
        $user = Auth::user();
        return compact('ads','user');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Ads $ads)
    {
        //
    }


    public function edit(Ads $ads)
    {
        //
    }


    public function update(Request $request, Ads $ads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ads $ads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ads $ads)
    {
        //
    }
}

