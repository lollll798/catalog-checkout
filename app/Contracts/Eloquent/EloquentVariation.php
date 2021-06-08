<?php

namespace App\Contracts\Eloquent;

use App\Models\Variation;
use App\Contracts\VariationInterface;

class EloquentVariation implements VariationInterface
{
    public function store(array $variation): array
    {
        $result = Variation::create([
            'item_id' => $variation['item_id'],
            'variation_id' => $variation['variation_id'],
            'variation_name' => $variation['variation_name'],
            'selected_unit' => $variation['selected_unit'],
        ]);
        return $result->toArray();
    }
}
