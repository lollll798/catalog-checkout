<?php

namespace App\UseCases\OrderPurchase;

use App\Traits\Hash;

class EncodeOrderPurchase
{
    use Hash;
    public function execute($pos)
    {
        $encodedPOs = [];
        foreach ($pos as $po) {
            $po['idx'] = $this->encode($po['id']);
            array_push($encodedPOs, $po);
        }

        return $encodedPOs;
    }
}
