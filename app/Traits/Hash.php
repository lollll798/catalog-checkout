<?php

namespace App\Traits;

use Hashids\Hashids;

trait Hash {
    private $length = 30;
    private $format = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';

    public function encode($id)
    {
        $hashids = new Hashids(env('APP_NAME'), $this->length, $this->format);
        return $hashids->encode($id);
    }

    public function decode($id) {
        $hashids = new Hashids(env('APP_NAME'), $this->length, $this->format);
        return $hashids->decode($id)[0];
    }
}
