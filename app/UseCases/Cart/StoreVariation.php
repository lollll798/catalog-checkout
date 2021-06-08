<?php

namespace App\UseCases\Cart;

use App\Contracts\VariationInterface;
class StoreVariation
{
    private $variation;
    public function __construct(VariationInterface $variation) {
        $this->variation = $variation;
    }

    public function execute($itemID, $variations, $variationDetails)
    {
        if(count($variationDetails) > 0) {
            foreach ($variationDetails as $variationKey => $variation) {
                $selectedUnit = $variations[$variationKey]['val'];
                $data = [
                    'item_id' => $itemID,
                    'variation_id' => (int)$variation['id'],
                    'variation_name' => trim($variation['name'], ' '),
                    'selected_unit' => trim($selectedUnit, ' '),
                ];
                $this->variation->store($data);
            }
        }

        return true;
    }
}
