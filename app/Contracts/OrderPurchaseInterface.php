<?php

namespace App\Contracts;

interface OrderPurchaseInterface {
    public function storePO(array $data): array;

    public function getPO(int $orderPurchaseID): array;

    public function getPOs(int $userID): array;

    public function getPOItems(int $orderPurchaseID): array;

    public function updateOrderPurchase($orderPurchaseID, $status): int;
}
