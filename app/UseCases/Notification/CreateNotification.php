<?php

namespace App\UseCases\Notification;

use App\Models\OrderPurchase;
use App\Traits\Hash;
use App\Models\User;
use App\Notifications\PurchaseOrder;
use App\Contracts\OrderPurchaseInterface;

class CreateNotification
{
    use Hash;
    private $orderPurchase;
    public function __construct(OrderPurchaseInterface $orderPurchase) {
        $this->orderPurchase = $orderPurchase;
    }

    public function execute($userID, $orderPurchaseID)
    {
        $user = User::find($userID);
        $po = $this->orderPurchase->getPO($orderPurchaseID);
        $data = [
            'order_purchase_id' => $orderPurchaseID,
            'message' => $po['po_no'].' has been canceled by seller.',
        ];
        $user->notify(new PurchaseOrder($data));
        return true;
    }
}
