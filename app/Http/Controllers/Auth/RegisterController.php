<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    public function showRegistrationForm()
    {
        $cities = City::all();
        return view('auth.register',compact('cities'));
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'min:10','unique:users'],
            'user_name' => ['required', 'string', 'max:255', 'unique:users','min:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'city_id' => ['required'],

        ]);

        if ($validator->fails()) {
            $request->session()->flash('errors', $validator->errors());
            return redirect()->back()->withInput();
        }
        $user=  User::create([
            'name' => $request['name'],
            'user_name' => $request['user_name'],
            'phone' => $request['phone'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'city_id' => $request['city_id'],
            'password' => Hash::make($request['password']),
        ]);
        \Auth::login($user);
        return redirect()->route('home');
    }
}
