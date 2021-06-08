<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'po_no',
        'status',
        'subtotal_price',
        'shipping_price',
        'total_price',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
