<?php

namespace App\UseCases\OrderPurchase;

use App\Contracts\OrderPurchaseInterface;
class CreateOrderPurchase
{
    private $orderPurchase;
    public function __construct(OrderPurchaseInterface $orderPurchase) {
        $this->orderPurchase = $orderPurchase;
    }

    public function execute($poNumber, $userID)
    {
        $data = [
            'user_id' => $userID,
            'po_no' => $poNumber,
        ];
        $po = $this->orderPurchase->storePO($data);

        return $po;
    }
}
