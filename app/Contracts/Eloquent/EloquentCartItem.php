<?php

namespace App\Contracts\Eloquent;

use App\Models\Cart;
use App\Models\Item;
use App\Contracts\CartItemInterface;

class EloquentCartItem implements CartItemInterface
{
    public function getCart(int $userID): array
    {
        $result = Cart::where('user_id', $userID)->get();
        return $result->toArray();
    }

    public function storeCartItems(array $items): array
    {
        $result = Item::create([
            'cart_id' => $items['cart_id'],
            'product_id' => $items['product_id'],
            'qty' => $items['qty'],
        ]);
        return $result->toArray();
    }

    public function getCartItems(int $cartID, int $status, $order_id_purchase): array
    {
        $result = Item::with('components')->with('variations')->where([
            'cart_id' => $cartID,
            'status' => $status,
            'order_purchase_id' => $order_id_purchase
        ])->get();
        return $result->toArray();
    }

    public function updateCartItemsStatus(array $itemsIDs, string $orderPurchaseID): int
    {
        $result = Item::whereIn('id', $itemsIDs)->update([
            'status' => 1,
            'order_purchase_id' => $orderPurchaseID,
        ]);
        return $result;
    }

    public function getPurchaseItems(int $orderPurchaseID): array
    {
        $result = Item::where([
            'order_purchase_id' => $orderPurchaseID
        ])->get();
        return $result->toArray();
    }
}
