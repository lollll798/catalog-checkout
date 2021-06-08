<?php

namespace App\UseCases\Product;

use App\Contracts\ProductDetailInterface;
use stdClass;

class AssignVariation implements ProductDetailInterface
{
    protected $productDetail;
    function __construct(ProductDetailInterface $productDetail)
    {
        $this->productDetail = $productDetail;
    }

    public function setData($product, $item)
    {
        $item = $this->productDetail->setData($product, $item);
        $item->variations = $this->formatAttributes($product->attributes, $product->default_attributes, $item);
        $item->variation_stock = $this->formatVariationStock($product->attributes, $product->variations);
        return $item;
    }

    private function formatAttributes($attributes, $default, $item)
    {
        if (count($attributes) === 0) {
            return $attributes;
        }

        foreach ($attributes as $attr) {
            $options = [];
            if (isset($attr->options) !== true) {
                continue;
            }

            foreach ($attr->options as $opt) {
                $option = new stdClass;
                $option->val = $opt;
                $data = [$attr->name, $opt];
                $option->default = $this->assignDefault($default, $data);
                $options[] = $option;
            }
            $attr->options = $options;
        }
        return $attributes;
    }

    private function assignDefault($default, $data)
    {
        [$attrName, $option] = $data;
        if (count($default) > 0) {
            $variationIndex = array_search($attrName, array_column($default, 'name'));
            if (strtolower($default[$variationIndex]->option) == strtolower($option)) {
                return 1;
            }
        }
        return 0;
    }

    private function formatVariationStock($attributes, $variations)
    {
        $stock = [];
        if (count($attributes) === 0) {
            return $stock;
        }

        foreach ($variations as $var) {
            $data = new stdClass;
            $data->product_id = $var->id;
            $data->sku = $var->sku;
            $data->regular_price = number_format((double)$var->regular_price, 2);
            $data->image = $var->image;
            $data->inventory = $var->inventory;
            $key = implode('_', array_column($var->attributes, 'option'));
            $stock[$key?:$attributes[0]->options[0]->val] = $data;
        }

        return $stock;
    }
}
