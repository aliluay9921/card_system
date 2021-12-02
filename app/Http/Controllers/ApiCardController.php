<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;
use App\Cardapi;
use App\Company;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ApiCardController extends Controller
{
    function multiexplode($string)
    {
        $delimiters = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
    // function to get all cards api to mobile 
    public function getCards()
    {
        $cards = Cardapi::select('id', 'type_card', 'sale_card', 'image')->where('active', 1)->whereNotNull("sale_card")->get();

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
            })->addColumn('sale_card', function ($row) {
                $span = '<span style="color:red"><b>لم يتم اضافة سعر البيع</b></span>';
                return $row->sale_card == null ?  $span  : $row->sale_card;
            })->addColumn('created_at', function ($row) {
                return  Carbon::createFromFormat('Y-m-d H:i:s',  $row->created_at)->format('Y-m-d');
            })->addColumn('image', function ($artist) {
                return '<img src="' . $artist->image . '" border="0" width="100" height="50" class="img-rounded" align="center"/>';
            })
            ->addColumn('action', function ($row) {
                return '<a href="/delete_cards/' . $row->id . '" class="btn  btn-danger"><i class="glyphicon glyphicon-edit"></i> حذف</a>
                        <a href="/edit_cards/' . $row->id . '" class="btn  btn-success"><i class="glyphicon glyphicon-edit"></i> تعديل</a>
                ';
            })->rawColumns(['image', 'action', 'sale_card'])


            ->make(true);
    }
    public function addCardApi()
    {
        $client = new \GuzzleHttp\Client();

        $request = $client->get('https://212.237.112.244:7091/pfAgegedkXamiBeodhafHyDo7Q8hcXSrvBouEiCoCazgfh6uG3ds2FcnCpokHmSVW/api/getmaininfo?userNumber=07804988301&token=1dd19e75487cfe81590cc3274e6b2daba9f91807ada816dfd283d5f74cdd66c7e8b560da4c0b54451361d5ea58766d946b83529ec6144f0afa715d1c9333e597&session=ebed7ae4a07b817ca7f9bbe64ffe31a73551ba7d312de8a8f1707311f5422e3c713e480916968c5257bed7283a9083f6598ab0cbfed8835706f85dcf6b2c1360', ['verify' => false]);
        $response = json_decode((string)$request->getBody(), true);
        foreach ($response['cardPrices'] as $key => $value) {
            $type = $this->multiexplode($key)[0];
            $data = [];
            $data = [
                'type_card' => $key,
                'buy_card' => $value,
            ];
            switch ($type) {
                case "amazon":
                    $data["image"] = '/image/companies/amazon.png';
                    break;
                case "ebay":
                    $data["image"] = '/image/companies/ebay.png';
                    break;

                case "fortnite":
                    $data["image"] = '/image/companies/fortnite.png';
                    break;

                case "freefire":
                    $data["image"] = '/image/companies/y7heT9OWsp9vQqeSK2x8nwPdf.jpg';
                    break;

                case "googleplay":
                    $data["image"] = '/image/companies/UgIZsBfyxG2xZ0phM84etTVDJ.png';
                    break;

                case "hulu":
                    $data["image"] = '/image/companies/hulu.png';
                    break;

                case "imvu":
                    $data["image"] = '/image/companies/imvu.png';
                    break;

                case "internetasiace":
                    $data["image"] = '/image/companies/OmcmNs6HU1d5cXVJiwartNxOF.png';
                    break;

                case "itunes":
                    $data["image"] = '/image/companies/ihXGjSo2kOTzEHCo3PBLUkpfD.png';
                    break;

                case "korek":
                    $data["image"] = '/image/companies/korek_avatar.jpg';
                    break;

                case "mastercard":
                    $data["image"] = '/image/companies/mastercard.png';
                    break;

                case "netflix":
                    $data["image"] = '/image/companies/TGKR4kH3kUvpCNCU7EUYhR7cX.jpg';
                    break;

                case "nintendo":
                    $data["image"] = '/image/companies/nintendo.png';
                    break;

                case "playstation":
                    $data["image"] = '/image/companies/6zu1VeKgA9wdkj6de4aNvT8jC.png';
                    break;

                case "pubg":
                    $data["image"] = '/image/companies/726AEXvgzSbv3B4BFZqJCIE0c.jpeg';
                    break;

                case "razer":
                    $data["image"] = '/image/companies/razer.png';
                    break;

                case "roblax":
                    $data["image"] = '/image/companies/roblax.png';
                    break;

                case "skype":
                    $data["image"] = '/image/companies/skype.png';
                    break;

                case "spotify":
                    $data["image"] = '/image/companies/spotify.png';
                    break;

                case "starzplay":
                    $data["image"] = '/image/companies/starzplay.png';
                    break;

                case "steam":
                    $data["image"] = '/image/companies/swDkfKVoKnwlV7xA9JUvYnJxa.jpg';
                    break;

                case "shahed":
                    $data["image"] = '/image/companies/Wz76BHXjReQILDoVoL0jclGfk.jpg';
                    break;

                case "vipblut":
                    $data["image"] = '/image/companies/vipblut.jfif';
                    break;

                case "careem":
                    $data["image"] = '/image/companies/careem.png';
                    break;

                case "xbox":
                    $data["image"] = '/image/companies/2FlttxWTtyeLgQVfuSBLqsgOV.png';
                    break;
            }
            Cardapi::create($data);
        }

        return redirect('/show_cards');
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
        $data = [];
        $data = [
            'sale_card' => $request->sale_card,
            'active' => $request->active == '1' ? true : false
        ];
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $path = '/image/companies/';
            $file_name = Str::random(25) . '.' . $image->getClientOriginalExtension();
            $request->file('image')->move(public_path() . $path, $file_name);
            $data["image"] = $path . $file_name;
        }
        // return $data;
        Cardapi::find($request->id)->update($data);
        return redirect('/show_cards');
    }

    public function buyCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item' => 'required|exists:cardapis,type_card'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $card = Cardapi::where("type_card", $request->item)->first();
        $user = User::find(auth()->user()->id);
        $balance = $user->balance;
        if ($user->balance < $card->sale_card) {
            return response()->json([
                "error" => "ليس لديك رصيد كافي لشراء هذه البطاقة رصيدك الحالي هو " . auth()->user()->balance
            ], 404);
        } else {
            $client = new \GuzzleHttp\Client();
            $request = $client->get('https://212.237.112.244:7091/pfAgegedkXamiBeodhafHyDo7Q8hcXSrvBouEiCoCazgfh6uG3ds2FcnCpokHmSVW/api/buyCard?userNumber=07804988301&token=1dd19e75487cfe81590cc3274e6b2daba9f91807ada816dfd283d5f74cdd66c7e8b560da4c0b54451361d5ea58766d946b83529ec6144f0afa715d1c9333e597&session=ebed7ae4a07b817ca7f9bbe64ffe31a73551ba7d312de8a8f1707311f5422e3c713e480916968c5257bed7283a9083f6598ab0cbfed8835706f85dcf6b2c1360&itemTag=' . $request->item, ['verify' => false]);
            $response = json_decode((string)$request->getBody(), true);
            $new_balance = $user->balance - $card->sale_card;
            $user->update([
                "balance" => $user->balance - $card->sale_card
            ]);
            Log::create([
                'user_id' => auth()->user()->id,
                'before' => $balance,
                'after' => $new_balance,
                'points' => $card->sale_card * 0.05,
                'key' => $response["Balane"]["ActionNumber"],
                'amount' => $card->sale_card,
                'transfer_out' => 1,
                'created_at' => now(),
                "api_card_id" =>  $card->id,
                "type_action" => 1
            ]);
            return response()->json([
                "success" => "تمت عملية شراء البطاقة بنجاح",
                "result" => $response
            ], 200);
            // عملية رسبونس موقتاً يجب ازالة الامور الغير مستخدمة
        }
    }

    public function refreshApiCard()
    {
        Cardapi::truncate();
        return redirect("/add_card_api");
    }
    public function deleteCards($id)
    {
        Cardapi::find($id)->delete();
        return back();
    }
}