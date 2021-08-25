<?php

namespace App\Http\Controllers;

use App\Amount;
use App\Card;
use App\City;
use App\Company;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class CardController extends Controller
{

    public function index()
    {

        return view('cards.card.index');
    }

    function dataTable()
    {
        $cards = Card::with('company', 'amount', 'city', 'user');
        return Datatables::of($cards)
            ->addColumn('status', function ($row) {
                if ($row->used) {
                    return "مباع";
                }
                return "جديد";
            })->addColumn('profit', function ($row) {
                return $row->sale_price - $row->puy_price;
            })->editColumn('created_at', function ($data) {
                return $data->created_at->toDateTimeString();
            })->editColumn('amount.value', function ($row) {
                return number_format($row->amount->value);
            })
            ->editColumn('puy_price', function ($row) {
                return number_format($row->puy_price);
            })->editColumn('sale_price', function ($row) {
                return number_format($row->sale_price);
            })
            ->filterColumn('used', function ($query, $keyword) {
                if (strpos($keyword, 'جد') !== false) {
                    $query->where('used', 0);
                } else if (strpos($keyword, 'مب') !== false) {
                    $query->where('used', 1);

                }

            })
            ->make(true);
    }

    public function create()
    {
        $companies = Company::where('active', 1)->get();
        $cities = City::where('active', 1)->get();
        $amounts = Amount::where('active', 1)->get();
        return view('cards.card.create', compact('cities', 'amounts', 'companies'));

    }


    public function store(Request $request)
    {
//        return $request->all();
        $validation = Validator::make($request->all(),
            [
                'amount_id' => 'required|exists:amounts,id',
                'company_id' => 'required|exists:companies,id',
                'city_id' => 'required|exists:cities,id',
                'puy_price' => 'required',
                'sale_price' => 'required',
                'file' => 'required|mimes:csv,txt',
                'owner' => 'required',
//                ' ' => 'required|exists:users,id',
            ], [
                'amount_id.required' => 'يرجى اختيار الفئه',
                'amount_id.exists' => 'حدث خطا اعد العمليه',

                'company_id.required' => 'يرجى اختيار الشركه',
                'company_id.exists' => 'حدث خطا اعد العمليه',


                'city_id.required' => 'يرجى اختيار المدينة',
                'city_id.exists' => 'حدث خطا اعد العمليه',


                'puy_price.required' => 'يرجى ادخال سعر الشراء',

                'sale_price.required' => 'يرجى ادخال سعر البيع',

                'file.required' => 'يرجى رفع ملف',
                'owner.required' => 'يرجى تحديد المالك',

            ]
        );

        if ($validation->fails()) {
            $request->session()->flash('error', $validation->errors()->first());
            return redirect()->back()->withInput();
        }
        $file = $request->file;
        $collection_id = Card::max('collection_id') + 1;

        DB::beginTransaction();
        try {
            foreach (file($file) as $key => $line) {
                $info = explode(',', $line);

                if ($line && $line !== 0 && $line !== '' && $key > 0 && !empty($info[0]) && isset($info[1])) {

                    if (is_numeric($info[1])) {
                        $card = Card::firstOrCreate(
                            ['key' => $info[0], 'serial' => (int)$info[1]],
                            [
                                'amount_id' => $request->amount_id, 'company_id' => $request->company_id,
                                'puy_price' => $request->puy_price, 'sale_price' => $request->sale_price,
                                'city_id' => $request->city_id, 'used' => 0, 'created_by' => Auth::id(),
                                'created_at' => now(), 'collection_id' => $collection_id,
                                'puy_at' => null, 'owner' => $request->owner
                            ]);
                        if (!$card->wasRecentlyCreated) {
                            DB::rollback();
                            $request->session()->flash('error', $info[0] . "يرجى التحقق من رقم البطاقه");
                            return redirect()->back()->withInput();
                        }
                    } else {
                        DB::rollback();
                        $request->session()->flash('error', "يرجى التحقق من معلومات الملف المرفق ");
                        return redirect()->back();
                    }
                }
            }
            DB::commit();
            $request->session()->flash('status', "تمت الاضافه بنجاح رقم الوجبة $collection_id");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }


    public function show(Card $card)
    {
        //
    }

    public function showDisable()
    {
        $amounts = Amount::where('active', 1)->get();
        return view('cards.card.disable', compact('amounts'));

    }

    public function disable(Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'collection_id' => 'required|exists:cards,collection_id',
            ],
            [
                'collection_id.required' => 'يرجى ادخال قيمه',
                'collection_id.exists' => 'حدث خطا اعد العمليه',
            ]
        );

        if ($validation->fails()) {
            $request->session()->flash('error', $validation->errors()->first());
            return response($validation->errors()->first(), 422);
        }
        $card = Card::where('collection_id', $request->collection_id)->first();
        Card::where('collection_id', $request->collection_id)
            ->update(['disable' => !$card->disable]);
        $request->session()->flash('status', "$request->collection_id تمت تعطيل الوجبه رقم ");
        return response("$request->collection_id تمت تعطيل الوجبه رقم ", 200);


    }

    public function amount(Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'collection_id' => 'required|exists:cards,collection_id',
            ],
            [
                'collection_id.required' => 'يرجى ادخال قيمه',
                'collection_id.exists' => 'حدث خطا اعد العمليه',
            ]
        );

        if ($validation->fails()) {
            $request->session()->flash('error', $validation->errors()->first());
            return response($validation->errors()->first(), 422);
        }

        Card::where('collection_id', $request->collection_id)
            ->where('used', 0)
            ->update(
                [
                    'amount_id' => $request->amount,
                    'owner' => $request->owner,
                    'sale_price' => $request->sale_price,
                    'puy_price' => $request->puy_price,
                ]
            );
        $request->session()->flash('status', "$request->collection_id تمت تحديث الوجبه رقم ");
        return response("$request->collection_id تمت تحديث الوجبه رقم ", 200);


    }

    public function search(Request $request)
    {
        return Card::where(function ($q) use ($request) {
            $q->where('collection_id', 'like', "%$request->q%")
                ->orwhere('key', 'like', "%$request->q%");
        })->where('used', 0)
            ->orderby('collection_id', 'desc')
            ->with('amount', 'company', 'city', 'user')
            ->get();
    }


    public function edit(Card $card)
    {
    }


    public function update(Request $request, Card $card)
    {
        return $request->all();
    }


    public function destroy(Card $card)
    {
        //
    }
}
