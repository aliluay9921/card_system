<?php

namespace App\Http\Controllers\api\v1;

use App\Amount;
use App\Card;
use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller

{

    public function index()
    {
 if (isset($_GET['prepaid_cards'])) {
            $companies = Company::where('active', 1)->whereIn('name', ['korek','Asiacell','Zain iraq'])->get();
 $cards = [];

            $cards_zain = [
                ['value' => 5000,   'sale_price' => 6075],
                ['value' => 10000,  'sale_price' => 12150],
                ['value' => 25000,  'sale_price' => 30325],
 		['value' => 30000,  'sale_price' => 36300],
                ['value' => 35000,  'sale_price' => 42550],
                ['value' => 50000,  'sale_price' => 60800],
	        ['value' => 100000, 'sale_price' => 122300],
            ];

            $cards_asia = [
                ['value' => 1000, 'sale_price' => 1195],
                ['value' => 2000, 'sale_price' => 2390],
                ['value' => 3000, 'sale_price' => 3585],
                ['value' => 4000, 'sale_price' => 4780],
                ['value' => 5000, 'sale_price' => 5975],
                ['value' => 6000, 'sale_price' => 7200],
	        ['value' => 7000, 'sale_price' => 8365],
                ['value' => 8000, 'sale_price' => 9560],
                ['value' => 9000, 'sale_price' => 10755],
                ['value' => 10000, 'sale_price' => 12000],
                ['value' => 15000, 'sale_price' => 17925],
                ['value' => 25000, 'sale_price' => 29875],
                ['value' => 50000, 'sale_price' => 60000],
                ['value' => 100000, 'sale_price' => 120000],
            ];

            $cards_korek = [];
            $companies[0]->cards = $cards_korek;
            $companies[1]->cards = $cards_asia;
            $companies[2]->cards = $cards_zain;
        }else{
        $companies = Company::where('active', 1)
            ->orderby('id', 'desc')->get();


        $cards_list = Card::where('used', 0)->leftJoin('amounts', 'amounts.id', '=', 'cards.amount_id')->leftJoin('companies', 'companies.id', '=', 'cards.company_id')
            ->groupBy('amount_id')
            ->groupby('company_id')
            ->orderby('amount_id')
            ->select('cards.sale_price', 'amounts.value', 'companies.name', 'companies.id')->get();

        $cards = [];
        foreach ($companies as $company) {
            $cards = [];
            foreach ($cards_list as $card) {
                if ($company->id == $card->id) {
                    $cards[] = ['value' => $card->value, 'sale_price' => $card->sale_price];
                }
                $company->cards = $cards;
            }
        }

}
       

        return compact('companies');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Company $company)
    {
        $cards = Amount::whereHas('cards', function ($q) use ($company) {
            $q->where('company_id', $company->id)->where('used', 0);
        })->where('active', 1)->get(['id', 'value']);
        return compact("company", 'cards');
    }


    public function edit(Company $company)
    {
        //
    }


    public function update(Request $request, Company $company)
    {
        //
    }


    public function destroy(Company $company)
    {
        //
    }
}