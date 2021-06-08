<?php

namespace App\UseCases\Product;

use App\Contracts\ProductDetailInterface;
use App\UseCases\API\GetProductDetail;
use stdClass;

class AssignComposite implements ProductDetailInterface
{
    protected $productDetail;
    function __construct(ProductDetailInterface $productDetail)
    {
        $this->productDetail = $productDetail;
    }

    public function setData($product, $item)
    {
        $item = $this->productDetail->setData($product, $item);
        $item->composite_components = $this->formatComposite($product->composite_components, $product->composite_product_details);
        return $item;
    }

    private function formatComposite($compositeComponents, $componentProdDetails)
    {
        if (count($compositeComponents) === 0) {
            return $compositeComponents;
        }
        $composites = [];
        foreach ($compositeComponents as $key => $comp) {
            $composite = new stdClass;
            $composite->id = $comp->id;
            $composite->title = $comp->title;
            $composite->description = $comp->description;
            $composite->quantity_min = $comp->quantity_min;
            $composite->quantity_max = $comp->quantity_max;
            $composite->optional = $comp->optional;
            $composite->discount = $comp->discount;
            $composite->options = $this->assignOptions($comp->query_ids, $componentProdDetails->components[$key]->products, $comp->default_option_id);
            $composites[] = $composite;
        }

        return $composites;
    }

    private function assignOptions($queryIDs, $componentProdDetails, $defaultID)
    {
        $options = [];
        foreach ($queryIDs as $prodID) {
            $prod = new stdClass;
            $prod->product_id = $prodID;
            $prod->details = $this->getProductDetails($prodID);
            $options[] = $prod;
        }

        return $options;
    }

    private function getProductDetails($prodID)
    {
        $details = (new GetProductDetail)->execute($prodID, 1);
        return $details;
    }
}
