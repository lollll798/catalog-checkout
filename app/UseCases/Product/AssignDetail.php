<?php

namespace App\UseCases\Product;

use App\Traits\Timestamp;
use App\Contracts\ProductDetailInterface;

class AssignDetail implements ProductDetailInterface
{
    use Timestamp;
    protected $productDetail;
    function __construct(ProductDetailInterface $productDetail)
    {
        $this->productDetail = $productDetail;
    }

    public function setData($product, $item)
    {
        $item = $this->productDetail->setData($product, $item);
        $item->last_modified = $this->formatDateTime($product->date_modified);
        $item->last_modified_format = $this->formatDateTime($product->date_modified, 1, 1);
        $item->sku = $product->sku;
        $item->date_on_sale_from = $product->date_on_sale_from;
        $item->date_on_sale_to = $product->date_on_sale_to;
        $item->weight = $product->weight;
        $item->dimensions = $product->dimensions;
        $item->inventory = isset($product->inventory)?:[];
        return $item;
    }
}
