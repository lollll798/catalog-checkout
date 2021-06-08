<?php

namespace App\UseCases\Product;

use App\Traits\Hash;
use App\Contracts\ProductDetailInterface;

class AssignBasic implements ProductDetailInterface
{
    use Hash;
    public function setData($product, $item)
    {
        $item->idx = $this->encode($product->id);
        $item->id = $product->id;
        $item->name = $product->name;
        $item->status = $product->status;
        $item->type = $product->type;
        $item->catalog_visibility = $product->catalog_visibility;
        $item->categories = $product->categories;
        $item->tags = $product->tags;
        $item->images = $product->images;
        $item->regular_price = $product->regular_price;
        $item->sale_price = $product->sale_price;
        $item->in_stock = $this->getInStock($product);
        $item->stock_quantity = $this->getStockQuantity($product);
        $item->variations_stock_quantity = $this->getVariarionQuantity($product);
        $item->min_price = $this->getMinimumPrice($product);
        $item->max_price = $this->getMaximumPrice($product, $item->min_price);
        $item->currency = 'RM';
        return $item;
    }

    private function getInStock($product)
    {
        if (count($product->variations) === 0) {
            return $product->in_stock;
        }
        return $product->in_stock || in_array(true, array_column($product->variations, 'in_stock'));
    }

    private function getStockQuantity($product)
    {
        if ($product->stock_quantity !== 0 && $product->stock_quantity != null) {
            return $product->stock_quantity;
        }

        return isset($product->inventory)? array_sum(array_column($product->inventory, 'stock_quantity')) : 0;
    }

    private function getVariarionQuantity($product)
    {
        if (count($product->variations) === 0) {
            return 0;
        }

        return array_sum(array_map('intval', array_column($product->variations, 'stock_quantity')))?:0;
    }

    private function getMinimumPrice($product)
    {
        if (count($product->variations) == 0) {
            return 0;
        }
        $lowestVariationRegular = min(array_map('doubleval', array_column($product->variations, 'regular_price')));
        $lowestVariationSales = min(array_map('doubleval', array_column($product->variations, 'sale_price')));
        $lowest = empty($lowestVariationSales) || $lowestVariationRegular < $lowestVariationSales ? $lowestVariationRegular : $lowestVariationSales;
        return $lowest?:0;
    }

    private function getMaximumPrice($product, $minPrice)
    {
        if (count($product->variations) == 0) {
            return 0;
        }
        $highestVariationRegular = max(array_map('doubleval', array_column($product->variations, 'regular_price')));
        if (empty($highestVariationRegular) || $highestVariationRegular == $minPrice) {
            return null;
        }
        return $highestVariationRegular;
    }
}
