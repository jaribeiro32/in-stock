<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
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
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());


        Http::fake(fn() => ['available' => true, 'price' => 3500,]);


        //When
        // I trigger the php artisan track command
        // and assuming the stock is available now

        $this->artisan('track')
            ->expectsOutput('All done!');

        //then
        //the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }
}
