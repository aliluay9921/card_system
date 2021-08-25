<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AirlockController extends Controller
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
            'user_name' => 'required',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 422);
        }

        $user = User::where('user_name', $request->user_name)->orwhere('phone', $request->phone)->first();


        if ($user) {
            if ($user->user_name == $request->user_name) {
                return response()->json([
                    'error' => ['user name exist'],
                ], 422);
            }
            if ($user->phone == $request->phone) {
                return response()->json([
                    'error' => ['Phone exist'],
                ], 422);
            }
        }
//        return $user;

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
            'lng' => $request->lng,
            'image' => $profileName,
            'balance' => 0,
            'created_at' => now(),
        ]);

        return response()->json([
            'token' => $user->createToken($request->user_name)->plainTextToken,
            'user' => $user,
        ], 200);
    }

}
