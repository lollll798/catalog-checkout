<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = ['item_type', 'item_id', 'variation_id', 'variation_name', 'selected_unit'];

    public function items()
    {
        return $this->belongsTo(Item::class);
    }

    public function components()
    {
        return $this->belongsTo(Component::class);
    }
}
