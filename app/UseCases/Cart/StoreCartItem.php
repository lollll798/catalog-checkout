<?php

namespace App\UseCases\Cart;

use App\Contracts\CartItemInterface;
class StoreCartItem
{
    private $cartItem;
    public function __construct(CartItemInterface $cartItem) {
        $this->cartItem = $cartItem;
    }

    public function execute($cartID, $productID, $qty)
    {
        $data = [
            'cart_id' => $cartID,
            'product_id' => $productID,
            'qty' => $qty,
        ];
        $item = $this->cartItem->storeCartItems($data);

        return $item;
    }
}
