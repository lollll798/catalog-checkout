<?php

namespace App\UseCases\Cart;

use App\Traits\Hash;
use App\UseCases\API\GetProductDetail;

class AssignCartDetails
{
    use Hash;
    public function execute($items, $products)
    {
        $formatedItems = [];
        foreach ($items as $key => $item) {
            $product = $products[$key];
            $item['idx'] = $this->encode($item['id']);
            $item['images'] = $product->images;
            $item['name'] = $product->name;
            $item['sku'] = $product->sku;

            $formatedComponents = [];
            if (count($item['components']) > 0) {
                foreach ($item['components'] as $component) {
                    $componentProduct = (new GetProductDetail)->execute($component['selected_product_id']);
                    $component['name'] = $componentProduct->name;
                    array_push($formatedComponents, $component);
                }
                $item['components'] = $formatedComponents;
            }
            array_push($formatedItems, $item);
        }

        return $formatedItems;
    }
}
