<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'component_id', 'title', 'selected_product_id'];

    public function variation()
    {
        return $this->hasMany(Variation::class);
    }

    public function items()
    {
        return $this->belongsTo(Item::class);
    }
}
