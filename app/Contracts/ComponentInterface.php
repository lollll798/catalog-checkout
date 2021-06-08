<?php

namespace App\Contracts;

interface ComponentInterface {
    public function store(array $component): array;
}
