<?php

namespace App\Http\Controllers;

use App\Cardapi;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCardController extends Controller
{
    // function to get all cards api to mobile 
    public function getCards()
    {
        $cards = Cardapi::select('id', 'type_card', 'sale_card')->where('active', 1)->get();
        return response()->json([
            'message' => 'تم جلب العناصر بنجاح',
            'cards' => $cards,
        ], 200);
    }
    // function to show page cards 
    public function showCards()
    {
        return view('cards.cardApi.tableCardsApi');
    }
    function dataTable()
    {
        $cards = Cardapi::select('*');
        return Datatables::of($cards)
            ->addColumn('active', function ($row) {
                return $row->active == 1 ? 'فعال' : "غير فعال";
            })
            ->addColumn('action', function ($row) {
                return '<a href="/delete_cards/' . $row->id . '" class="btn  btn-danger"><i class="glyphicon glyphicon-edit"></i> حذف</a>
                        <a href="/edit_cards/' . $row->id . '" class="btn  btn-success"><i class="glyphicon glyphicon-edit"></i> تعديل</a>
                ';
            })

            ->make(true);
    }
    public function addCardApi()
    {
        $client = new \GuzzleHttp\Client();

        $request = $client->get('https://212.237.112.244:7091/pfAgegedkXamiBeodhafHyDo7Q8hcXSrvBouEiCoCazgfh6uG3ds2FcnCpokHmSVW/api/getmaininfo?userNumber=07804988301&token=1dd19e75487cfe81590cc3274e6b2daba9f91807ada816dfd283d5f74cdd66c7e8b560da4c0b54451361d5ea58766d946b83529ec6144f0afa715d1c9333e597&session=ebed7ae4a07b817ca7f9bbe64ffe31a73551ba7d312de8a8f1707311f5422e3c713e480916968c5257bed7283a9083f6598ab0cbfed8835706f85dcf6b2c1360', ['verify' => false]);
        $response = json_decode((string)$request->getBody(), true);
        foreach ($response['cardPrices'] as $key => $value) {
            Cardapi::create([
                'type_card' => $key,
                'buy_card' => $value
            ]);
        }
        return redirect('/');
    }
    public function editCards($id)
    {
        $card = Cardapi::find($id);
        return view('cards.cardApi.editCardApi', compact('card'));
    }
    public function updateCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cardapis,id'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        Cardapi::find($request->id)->update([
            'sale_card' => $request->sale_card,
            'active' => $request->active == '1' ? true : false
        ]);
        return redirect('/show_cards');
    }
    public function deleteCards($id)
    {
        Cardapi::find($id)->delete();
        return back();
    }
}