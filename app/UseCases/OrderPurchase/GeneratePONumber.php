<?php

namespace App\UseCases\OrderPurchase;

use App\Contracts\OrderPurchaseInterface;
class GeneratePONumber
{
    private $orderPurchase;
    public function __construct(OrderPurchaseInterface $orderPurchase) {
        $this->orderPurchase = $orderPurchase;
    }

    public function execute($userID)
    {
        $pos = $this->orderPurchase->getPOs($userID);
        $poNumber = 'PO-'.str_pad(count($pos) + 1, 4, "0", STR_PAD_LEFT);
        return $poNumber;
    }
}
