<?php

namespace App\Http\Controllers\api\v1;

use App\Company;
use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller

{

    public function index(Request $request)
    {
        $skip = $request->limit * ($request->page - 1);

        $filters = [];
        $filters[] = array(
            'name' => 'الكل',
            'image' => asset('image/companies/cards_cover.png'),
        );
        $companies = Company::where('active', 1)->orderBy('id', 'asc')->get();

        foreach ($companies as $company) {
            $filters[] = array(
                'name' => $company->name,
                'image' => $company->avatar_image,
            );
        }

        $filters[] = array(
            'name' => 'الرصيد المحول',
            'image' => asset('image/companies/transfer.png'),
        );


        $filters = collect($filters);

        $title = $filters->filter(function ($item) use ($request) {
            return $item['name'] === $request->filter;
        })->values();


        $title = $title->first();

        if (!$request->filter || $request->filter == "الكل") {

            $total_page = Log::where('user_id', Auth::id())
//                ->orWhere(function ($query) {
//                    $query->where('transfer_id', Auth::id());
//                    $query->where('transfer_type', 'App\\User');
//                })
                ->count();
            $reports ['total_page'] = ceil($total_page / $request->limit);


            $reports['data'] = Log::where('user_id', Auth::id())
//                ->orWhere(function ($query) {
//                    $query->where('transfer_id', Auth::id());
//                    $query->where('transfer_type', 'App\\User');
//                })
                ->skip($skip)
                ->take($request->limit)
                ->orderBy('id', 'desc')
                ->with('transfer')
                ->get();


        } elseif ($request->filter == "الرصيد المحول") {

            $total_page = Log::where('user_id', Auth::id())
                ->where('transfer_type', 'App\\User')
                ->orWhere(function ($query) {
                    $query->where('transfer_id', Auth::id());
                })->count();

            $reports ['total_page'] = ceil($total_page / $request->limit);

            $reports['data'] = Log::where('user_id', Auth::id())
                ->where('transfer_type', 'App\\User')
                ->orWhere(function ($query) {
                    $query->where('transfer_id', Auth::id());
                })
                ->with('transfer')
                ->skip($skip)
                ->take($request->limit)
                ->orderBy('id', 'desc')
                ->get();
        } else {

            $company = Company::where('name', $request->filter)->first();

            $total_page = Log::where('user_id', Auth::id())
                ->where('transfer_type', 'App\\Company')
                ->where('transfer_id', $company->id)
                ->count();
            $reports ['total_page'] = ceil($total_page / $request->limit);

            $reports['data'] = Log::
            where('user_id', Auth::id())
                ->where('transfer_type', 'App\\Company')
                ->where('transfer_id', $company->id)
                ->with('transfer')
                ->skip($skip)
                ->take($request->limit)
                ->orderBy('id', 'desc')
                ->get();
        }

        return compact('title', 'filters', 'reports');
    }

}
