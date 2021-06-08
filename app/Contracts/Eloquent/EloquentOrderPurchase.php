<?php

namespace App\Contracts\Eloquent;

use App\Models\Item;
use App\Models\OrderPurchase;
use App\Contracts\OrderPurchaseInterface;

class EloquentOrderPurchase implements OrderPurchaseInterface
{
    public function storePO(array $data): array
    {
        $result = OrderPurchase::create([
            'user_id' => $data['user_id'],
            'po_no' => $data['po_no'],
        ]);
        return $result->toArray();
    }

    public function getPO(int $orderPurchaseID): array
    {
        $result = OrderPurchase::find($orderPurchaseID);
        return $result->toArray();
    }

    public function getPOs(int $userID): array
    {
        $result = OrderPurchase::where('user_id', $userID)->get();
        return $result->toArray();
    }

    public function getPOItems(int $orderPurchaseID): array
    {
        $result = Item::with('components')->with('variations')->where([
            'order_purchase_id' => $orderPurchaseID,
            'status' => 1
        ])->get();
        return $result->toArray();
    }

    public function updateOrderPurchase($orderPurchaseID, $status): int
    {
        $result = OrderPurchase::where('id', $orderPurchaseID)->update([
            'status' => $status,
        ]);
        return $result;
    }
}
