<?php

namespace App\UseCases\OrderPurchase;

use App\Traits\Timestamp;

class GetFormatedDate
{
    use Timestamp;
    public function execute($po)
    {
        $formatedPO = $po;
        $formatedPO['checkout_date'] = $this->formatDateTime($po['created_at'], 3, 1);
        $formatedPO['last_action_date'] = $this->formatDateTime($po['updated_at'], 3, 1);

        return $formatedPO;
    }
}
