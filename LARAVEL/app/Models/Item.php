<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id'; // Custom primary key

    protected $fillable = [
        'item_name',
        'item_quantity',
        'item_unitPrice',
        'item_totalPrice',
        'invoice_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}

