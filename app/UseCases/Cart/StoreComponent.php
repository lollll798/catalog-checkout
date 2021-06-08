<?php

namespace App\UseCases\Cart;

use App\Contracts\ComponentInterface;
class StoreComponent
{
    private $component;
    public function __construct(ComponentInterface $component) {
        $this->component = $component;
    }

    public function execute($itemID, $composites, $compositeDetails)
    {
        if(count($compositeDetails) > 0) {
            foreach ($compositeDetails as $compositeKey => $composite) {
                $selectedOpt = $composites[$compositeKey]['val'];
                $data = [
                    'item_id' => $itemID,
                    'component_id' => (int)$composite['id'],
                    'title' => $composite['title'],
                    'selected_product_id' => (int)$selectedOpt,
                ];
                $this->component->store($data);
            }
        }

        return true;
    }
}
