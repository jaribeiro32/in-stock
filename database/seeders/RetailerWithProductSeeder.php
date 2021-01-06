<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notebook = Product::create(['name' => 'Acer Notebook']);

        $bestBy = Retailer::create(['name' => 'Best Buy']);

        $bestBy->addStock($notebook, new Stock([
            'price'    => 2000,
            'url'      => 'https://test.com',
            'sku'      => '123',
            'in_stock' => false,
        ]));
    }
}
