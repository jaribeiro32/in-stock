<?php

namespace App\Models;

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
        $status = $this->retailer
            ->client()
            ->checkAvailability($this);

        // and then refresh the current stock record
        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price,
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

}
