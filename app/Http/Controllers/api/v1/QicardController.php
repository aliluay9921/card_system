<?php

namespace App\Http\Controllers\api\v1;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class QicardController extends Controller
{
    public function addBill(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amounts' => ['required'],

        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }
        $client = new Client([
            'base_url' => 'https://api.tasdid.net'
        ]);
        $request_guzzele = $client->request('PUT', 'https://api.tasdid.net/v1/api/Provider/AddBill', ["headers" => [
            'content-type' => 'application/json',
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIyMTkwMDRhZS01NTk2LTQ4MjAtYTVhNC1mMmUyZjljOGU0ZjUiLCJlbWFpbCI6IkFsbmFzcmV5OTFAdGFzZGlkLm5ldCIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL25hbWUiOiJjYXJkIGNlbnRlciIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6IlByb3ZpZGVyIiwiRmVSb2xlIjoiUHJvdmlkZXIiLCJmaXJzdExvZ2luIjoiRmFsc2UiLCJmaWxlSWQiOiIiLCJtZXRob2QiOiIwIiwianRpIjoiNDk0NmQ4NmEtNjBlNy00NTdkLTg5ODUtMjliZGE0NjIwYmFkIiwibmJmIjoxNjI5ODk4Nzc5LCJleHAiOjE2MzAxNTc5NzksImlzcyI6Iklzc3VlciIsImF1ZCI6IkF1ZGllbmNlIn0.4avdZt_x6VZ2zgdE7CejrD0H-Yx9KgfCV4a2PGEpxzg'
        ], 'json' => [
            "payId" => "",
            "customerName" => auth()->user()->user_name,
            "phoneNumber" => auth()->user()->phone,
            "dueDate" => Carbon::now()->addMonth(),
            "serviceId" => "89284fdb-5a5e-4850-afb6-f025cd664ef8",
            "amount" => $request->amounts,
            "note" => "طلب خدمة"
        ]]);


        return $request_guzzele->getStatusCode();
    }

    public function getNotification(Request $request)
    {
        /*

        string PayId
string PhoneNumber
string CustomerName
Guid ServiceId
DateTime CreateDate
DateTime DueDate
DateTime PayDate
int Status
decimal Amount
string Note
string Key ((will shared privately via email)) }
        */
        $validator = Validator::make($request->all(), [
            'Amount' => ['required'],
            'PhoneNumber' => ['required'],

        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }

        $user = User::where('phone', $request->PhoneNumber)->first();
        $balance = ($request->Amount) + $user->balance;
        $user->update([
            'balance' => $balance,
        ]);

        return $user;
    }
}