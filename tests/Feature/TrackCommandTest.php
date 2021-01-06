<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function itTracksProductStock()
    {
        // Given
        // I have a product with stock
        $notebook = Product::create(['name' => 'Acer Notebook']);

        $bestBy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($notebook->inStock());

        $stock = new Stock([
            'price'    => 2000,
            'url'      => 'https://test.com',
            'sku'      => '123',
            'in_stock' => false,
        ]);

        $bestBy->addStock($notebook, $stock);

        $this->assertFalse($stock->fresh()->in_stock);


        Http::fake(function () {
            return [
                'available' => true,
                'price'     => 3500,
            ];
        });


        //When
        // I trigger the php artisan track command
        // and assuming the stock is available now

        $this->artisan('track');

        //then
        //the stock details should be refreshed
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
