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

        if (isset($_GET['prepaid_cards'])) {
            $companies = Company::where('active', 1)->whereIn('name', ['زين', 'اسياسيل', 'كورك'])->get();
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