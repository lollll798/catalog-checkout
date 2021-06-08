<?php

namespace App\UseCases\Cart;

use App\Contracts\CartItemInterface;
class GetCartItems
{
    private $cartItem;
    public function __construct(CartItemInterface $cartItem) {
        $this->cartItem = $cartItem;
    }

    public function execute($cartID, $status = 0, $order_id_purchase = null)
    {
        return $this->cartItem->getCartItems($cartID, $status, $order_id_purchase);
    }
}
