<?php

namespace App\UseCases\Cart;

use App\Contracts\CartItemInterface;
class CheckoutItem
{
    private $cartItem;
    public function __construct(CartItemInterface $cartItem) {
        $this->cartItem = $cartItem;
    }

    public function execute($itemsIDs, $orderPurchaseID)
    {
        return $this->cartItem->updateCartItemsStatus($itemsIDs, $orderPurchaseID);
    }
}
