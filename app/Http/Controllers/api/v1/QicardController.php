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
        $login = $client->request('post', 'https://api.tasdid.net/v1/api/Auth/Token', ["headers" => [
            'content-type' => 'application/json',
        ], 'json' => [
            "username" => "Alnasrey91@tasdid.net",
            "password" => "&551(fWgA"
        ]]);
        $token =   json_decode((string) $login->getBody())->token;
        $request_guzzele = $client->request('PUT', 'https://api.tasdid.net/v1/api/Provider/AddBill', ["headers" => [
            'content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ], 'json' => [
            "payId" => "",
            "customerName" => auth()->user()->user_name,
            "phoneNumber" => auth()->user()->phone,
            "dueDate" => Carbon::now()->addMonth(),
            "serviceId" => "89284fdb-5a5e-4850-afb6-f025cd664ef8",
            "amount" => $request->amounts,
            "note" => "طلب خدمة"
        ]]);
        return $request_guzzele;
    }

    public function getNotification(Request $request)
    {
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