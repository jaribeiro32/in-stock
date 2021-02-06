<?php

namespace Tests\Unit;

use App\Clients\ClientException;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ItThrowsAnExceptionIfAClientIsNotFoundWhenTracking()
    {
        // Given I have a retailer with stock
        $this->seed(RetailerWithProductSeeder::class);

        // And if the retailer doesn't have a client class
        Retailer::first()->update(['name' => 'Foo Retailer']);

        // Then an exception should be thrown
        $this->expectException(ClientException::class);

        // If I track that stock
        Stock::first()->track();

    }
}
