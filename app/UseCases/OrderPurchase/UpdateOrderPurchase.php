<?php

namespace App\UseCases\OrderPurchase;

use App\Contracts\OrderPurchaseInterface;
class UpdateOrderPurchase
{
    private $orderPurchase;
    public function __construct(OrderPurchaseInterface $orderPurchase) {
        $this->orderPurchase = $orderPurchase;
    }

    public function execute($orderPurchaseID, $status)
    {
        return $this->orderPurchase->updateOrderPurchase($orderPurchaseID, $status);
    }
}
