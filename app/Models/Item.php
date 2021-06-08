<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'order_purchase_id', 'product_id', 'status', 'qty', 'unit_price', 'item_price'];
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function order_purchase()
    {
        return $this->belongsTo(OrderPurchase::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
