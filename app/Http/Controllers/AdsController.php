<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Ads_user;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ads::all();
        return view('cards.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::whereNotNull('activate_at')->get();
        return view('cards.ads.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //        return Ads::with('users')->get();


        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'image' => 'required |image',
                'url' => 'required ',
                'public' => 'required ',
                'users' => Rule::requiredIf($request->public == 0),

            ],
            [
                'title.required' => 'يرجى ادخال عنوان الاعلان',
                'image.required' => 'يرجى اختيار صوره الاعلان',
                'url.required' => 'يرجى ادخال الرابط الخاص بلاعلان',
                'public.required' => 'يرجى اختيار نوع الاعلان',
                'users.*' => 'يرجى اختيارالمستخدمين لهذا الاعلان',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = public_path() . '/image/ads/';
            $imageName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('image')->move($path, $imageName);
        }

        $ad = Ads::create([
            'title' => $request->title,
            'active' => 1,
            'url' => $request->url,
            'public' => $request->public,
            'image' => $imageName,
            'created_at' => now(),
        ]);


        if ($request->users && !$request->public) {
            foreach ($request->users as $user) {
                $ad->users()->create([
                    'user_id' => $user,
                    'created_at' => now(),
                ]);
            }
        }

        return back();
    }


    public function show(Ads $ads)
    {
        //
    }


    public function edit(Ads $ad)
    {
        $users = User::whereNotNull('activate_at')->get();
        $ad_users = Ads_user::where('ads_id', $ad->id)->pluck('user_id')->toArray();

        return view('cards.ads.edit', compact('ad', 'users', 'ad_users'));
    }


    public function update(Request $request, Ads $ad)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'url' => 'required ',
                'public' => 'required ',
                'users' => Rule::requiredIf($request->public == 0),
            ],
            [
                'title.required' => 'يرجى ادخال عنوان الاعلان',
                'image.required' => 'يرجى اختيار صوره الاعلان',
                'url.required' => 'يرجى ادخال الرابط الخاص بلاعلان',
                'public.required' => 'يرجى اختيار نوع الاعلان',
                'users.*' => 'يرجى اختيارالمستخدمين لهذا الاعلان',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        if ($request->hasFile('image') && $request->file('image') != null) {
            $image = $request->file('image');
            $path = public_path() . '/image/ads/';
            $imageName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('image')->move($path, $imageName);
            $ad->image = $imageName;
        }

        $ad->title = $request->title;
        $ad->active = $request->active;
        $ad->url = $request->url;
        $ad->public = $request->public;
        //        $ads->image = $imageName;
        $ad->updated_at = now();

        $ad->save();
        $ad->users()->sync($request->users);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ads $ads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ads $ads)
    {
        $ads->active = 0;
        $ads->save();
    }
}
