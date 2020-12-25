<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCode200FromServer(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testItChecksStockForProductsAtRetailers()
    {
        $notebook = Product::create(['name' => 'Acer Notebook']);

        $bestBy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($notebook->inStock());

        $stock = new Stock([
            'price'    => 2000,
            'url'      => 'https://test.com',
            'sku'      => '123',
            'in_stock' => true,
        ]);

        $bestBy->addStock($notebook, $stock);

        $this->assertTrue($notebook->inStock());
    }
}
