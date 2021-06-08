<?php

namespace App\Contracts;

interface CartItemInterface {
    public function getCart(int $userID): array;

    public function storeCartItems(array $items): array;

    public function getCartItems(int $cartID, int $status, $order_id_purchase): array;

    public function updateCartItemsStatus(array $itemsIDs, string $orderPurchaseID): int;

    public function getPurchaseItems(int $orderPurchaseID): array;
}
