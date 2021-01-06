<?php

namespace App\Models;

use Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $casts
        = [
            'in_stock' => 'boolean',
        ];

    public function track()
    {
        // Hia a APi endpoint for associate retailer
        if ($this->retailer->name == 'Best Buy') {

            //fetch the up-to-date details from the item
            $results = Http::get('https://foo.test')->json();

            // and then refresh the current stock record
            $this->update([
                'in_stock' => $results['available'],
                'price'    => $results['price'],
            ]);
        }
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
