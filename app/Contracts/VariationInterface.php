<?php

namespace App\Contracts;

interface VariationInterface {
    public function store(array $variation): array;
}
