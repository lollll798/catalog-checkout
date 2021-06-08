<?php

namespace App\Contracts\Eloquent;

use App\Models\Component;
use App\Contracts\ComponentInterface;

class EloquentComponent implements ComponentInterface
{
    public function store(array $component): array
    {
        $result = Component::create([
            'item_id' => $component['item_id'],
            'component_id' => $component['component_id'],
            'title' => $component['title'],
            'selected_product_id' => $component['selected_product_id'],
        ]);
        return $result->toArray();
    }
}
