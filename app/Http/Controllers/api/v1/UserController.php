<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Notifications\BalanceUpdate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function transaction(User $user, Request $request)
    {

        $validation = Validator::make($request->all(),
            [
                'amount' => 'required |numeric',
                'phone' => 'required | numeric',
                'password' => 'required',
            ]);


        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'يرجى التحقق من كلمه المرور'], 402);
        }


        $checkPhone = User::where('phone', $request->phone)->first();

        if (!$checkPhone || $checkPhone->phone === Auth::user()->phone) {
            return response()->json(['error' => "يرجى التحقق من الحساب المرسل اليه",], 402);
        }


        if ($request->amount < 1000) {
            return response()->json(['error' => "اقل مبلغ للتحويل 1000",], 402);
        }

        if ($user->balance < $request->amount)
            return response()->json(['error' => "ليس لديك رصيد كافي",], 402);

        $balance = $user->balance;
        $user->balance = $user->balance - $request->amount;
        $user->save();
        $checkPhone->balance = $checkPhone->balance + $request->amount;
        $checkPhone->save();

        $checkPhone->transfer()->create([
            'user_id' => $user->id,
            'before' => $balance,
            'after' => $user->balance,
            'points' => 0,
            'key' => NULL,
            'amount' => $request->amount,
            'created_at' => now(),
        ]);

        $user->transfer()->create([
            'user_id' => $checkPhone->id,
            'before' => $checkPhone->balance - $request->amount,
            'after' => $checkPhone->balance,
            'points' => 0,
            'transfer_out' => 0,
            'key' => NULL,
            'amount' => $request->amount,
            'created_at' => now(),
        ]);

        $title = "تحديث رصيد حسابك";
        $body = "اسلام رصيد محول";

        $checkPhone->notify(new BalanceUpdate($title, $body));

        return response()->json([
            'message' => "تم تحويل $request->amount بنجاح",
            'user' => $user
        ], 200);
    }

    function show()
    {
        $user = Auth::user();
        return compact('user');
    }
}
