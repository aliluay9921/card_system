<?php

namespace App\Http\Controllers;

use App\Company;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('cards.company.index', compact('companies'));
    }

    public function create()
    {
        return view('cards.company.create');
    }


    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'active' => 'required',
            'avatar' => 'required |image',
            'cover' => 'required |image',
            'color' => 'required ',
        ],
            [
                'name.required' => 'يرجى ادخال اسم الشركة',
                'active.required' => 'يرجى ادخال حاله الشركه',
                'avatar.required' => 'يرجى ادخال صوره لوكو الشركه',
                'cover.required' => 'يرجى ادخال صوره الغلاف للشركه',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $path = public_path() . '/image/companies/';
            $avatarName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('avatar')->move($path, $avatarName);
        }


        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $path = public_path() . '/image/companies/';
            $coverName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('cover')->move($path, $coverName);
        }

        Company::create([
            'name' => $request->name,
            'active' => $request->active,
            'avatar' => $avatarName,
            'cover' => $coverName,
            'created_at' => now(),
            'color' => $request->color
        ]);
        $request->session()->flash('status', "تمت الاضافه بنجاح");
        return redirect()->back();

    }


    public function show(Company $company)
    {
        //
    }


    public function edit(Company $company)
    {
        return view('cards.company.edit', compact('company'));
    }


    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'active' => 'required',
            'avatar' => ' image',
            'cover' => 'image',
        ],
            [
                'name.required' => 'يرجى ادخال اسم الشركة',
                'active.required' => 'يرجى ادخال حاله الشركه',
                'avatar.required' => 'يرجى ادخال صوره لوكو الشركه',
                'cover.required' => 'يرجى ادخال صوره الغلاف للشركه',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if ($request->hasFile('avatar') && $request->file('avatar') != null) {
            $image = $request->file('avatar');
            $path = public_path() . '/image/companies/';
            $avatarName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('avatar')->move($path, $avatarName);
            $company->avatar = $avatarName;

        }

        if ($request->hasFile('cover') && $request->file('cover') != null) {
            $image = $request->file('cover');
            $path = public_path() . '/image/companies/';
            $coverName = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('cover')->move($path, $coverName);
            $company->cover = $coverName;

        }
        $company->name = $request->name;
        $company->active = $request->active;
        $company->updated_at = now();
        $company->save();
        $request->session()->flash('status', "تمت التعديل بنجاح");
        return redirect()->back();


    }

    public function destroy(Company $company)
    {
        $company->active = 0;
        $company->save();

    }
  public function delete($id)
    {
        Company::find($id)->delete();
        return redirect()->back();
    }
}
