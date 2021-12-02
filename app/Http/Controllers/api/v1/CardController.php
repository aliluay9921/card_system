<?php

namespace App\Http\Controllers\api\v1;

use App\Amount;
use App\CahrgeBalance;
use App\Card;
use App\Company;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Card $card)
    {
    }


    public function edit(Card $card)
    {
        //
    }


    public function update(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric |min:0',
                'quantity' => 'required |numeric |min:0',
                'company_id' => 'required |numeric |min:0',
                'lng' => 'required',
                'lat' => 'required',
            ]
        );
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }
        if ($request->has('receiver_number')) {

            if (auth()->user()->balance < $request->amount) {
                return response()->json([
                    'error' => "ليس لديك رصيد كافي لديك فقط ",
                ], 404);
            }

            $payed = 0;
            CahrgeBalance::create([
                'amounts' => $request->amount,
                'sale_price' => $request->sale_price,
                'user_id' => auth()->user()->id,
                'phone_number' => $request->receiver_number
            ]);
            $payed += $request->amount;
            $user = auth()->user();
            $user->balance -= $request->sale_price;

            return response()->json([
                'message' => "$payed تم الشراء بقيمه ",
                'receiver_number' => $request->receiver_number,
                'user' => $user,
            ], 200);
        } else {

            $amount = Amount::where('value', $request->amount)->pluck('id')->first();
            if (!$amount) {
                return response()->json([
                    'error' => "يرجى التحقق من قيمه الشراء",
                ], 404);
            }
            $user = User::find(Auth::id());
            $cards = Card::where('used', 0)
                ->where('disable', 0)
                ->where('company_id', $request->company_id)
                ->where('amount_id', $amount)
                ->take($request->quantity)
                ->get();
            $sum = $cards->sum(function ($card) {
                return $card->sale_price;
            });
            if ($user->balance < $sum) {
                return response()->json([
                    'error' => "ليس لديك رصيد كافي لديك فقط $user->balance",
                ], 404);
            }
            if (count($cards) < $request->quantity) {
                return response()->json([
                    'error' => 'يتوفر ' . count($cards) . 'بطاقات فقط في الوفت الحالي',
                ], 404);
            }
            $keys = [];
            $company = Company::find($request->company_id);
            $payed = 0;
            $points = 0;
            foreach ($cards as $card) {
                $balance = $user->balance;
                $user->balance -= $card->sale_price;
                $user->save();
                $card->used = 1;
                $card->puy_at = now();
                $card->save();
                $keys[] = $card->key;
                $log = $company->transfer()->create([
                    'user_id' => Auth::id(),
                    'before' => $balance,
                    'after' => $user->balance,
                    'points' => $card->sale_price * 0.05,
                    'key' => $card->key,
                    'amount' => $request->amount,
                    'transfer_out' => 1,
                    'created_at' => now(),
                ]);
                $payed += $card->sale_price;
                $points += $log->points;
            }
            $user->points = $points;


            return response()->json([
                'message' => "$payed تم الشراء بقيمه ",
                'cards' => $keys,
            ], 200);
        }
    }

    public function destroy(Card $card)
    {
        //
    }
}
