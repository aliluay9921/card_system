<?php

namespace App\Http\Controllers;


use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{


    public function edit()
    {
        $cities=City::where('active',1)->get();
        return view('profile.edit',compact('cities'));
    }


    public function update(Request $request)
    {

        $user = auth()->user();
        $user->name = $request->name;
        $user->city_id = $request->city_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = public_path() . '/image/users/profile';
            $avatarName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('image')->move($path, $avatarName);
            $user->image = $avatarName;
        }
        $user->save();
        return back()->withStatus(__('Profile successfully updated.'));
    }


}
