<?php

namespace App\Http\Controllers\api\v1;

use App\User;
use App\CahrgeBalance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\resetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            //            'device_name' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }

        $user = User::where('user_name', $request->user_name)->orwhere('phone', $request->user_name)->first();


        if (!$user) {
            return response()->json([
                'error' => ['المعلومات التي وفرتها غير صحيحه.'],
            ], 422);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => ['المعلومات التي وفرتها غير صحيحه.'],
            ], 422);
        }
        return response()->json([
            'token' => $user->createToken($request->user_name)->plainTextToken,
            'user' => $user,
        ], 200);
    }

    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'min:10', 'unique:users'],
            'user_name' => ['required', 'string', 'max:255', 'unique:users', 'min:6'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'lat' => ['required', 'string'],
            'lng' => ['required', 'string'],
            'city_id' => ['required'],
        ]);


        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }


        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $path = public_path() . '/image/users/profile';
            $profileName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('profile')->move($path, $profileName);
        } else {
            $profileName = '';
        }

        $user = User::create([
            'name' => $request->name,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'lat' => $request->lat,
            'email' => $request->email,

            'lng' => $request->lng,
            'image' => $profileName,
            'city_id' => $request->city_id,
            'balance' => 0,
            'created_at' => now(),
        ]);

        return response()->json([
            'token' => $user->createToken($request->user_name)->plainTextToken,
            'user' => $user,
        ], 200);
    }

    // 
    public function resetPassword(Request $request)
    {
 $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);


        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'code' => random_int(100000, 999999)
        ]);

        $details = [
            'title' => 'رمز تغير كلمة المرور الخاصة بك في تطبيق card cnter',
            'body' => $user->code
        ];

        \Mail::to($request->email)->send(new resetPasswordMail($details));
        return response()->json([
            'success' => [
                'user' => $user,

            ],
            'errors' => false
        ]);
    }
    public function confirmPassword(Request $request)
    {
        // $request = $request->json()->all();
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'same:new_password'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }

        $user = User::where('code', $request->code)->first();
        $user->update([
            'password' => bcrypt($request->new_password),
            'code' => null
        ]);

        return response()->json([
            'success' => [
                'user' => $user,
            ],
            'errors' => false
        ]);
    }
    // 
    public function rechargeBalance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'balance' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }
        $user = User::find(auth()->user()->id);
        CahrgeBalance::create([
            'amounts' => $request->balance,
            'phone_number' => $user->phone
        ]);
        return response()->json([
            'success' => [
                'user_phone' => $user->phone,
                'balance' => $request->balance
            ],
            'errors' => false
        ]);
    }
    public function getrechargeBalance()
    {
        $get = CahrgeBalance::all();
        return response()->json([
            'success' => [
                'data' => $get,
                'status' => 200
            ],
            'errors' => false
        ]);
    }
}