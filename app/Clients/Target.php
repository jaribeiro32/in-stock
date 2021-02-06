<?php


namespace App\Clients;


use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class Target implements Client
{

    public function checkAvailability(Stock $stock): StockStatus
    {
        //fetch the up-to-date details from the item
        $results = Http::get('https://foo.test')->json();
        return $results;
    }

}
