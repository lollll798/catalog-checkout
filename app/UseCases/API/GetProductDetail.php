<?php

namespace App\UseCases\API;

use stdClass;
use App\UseCases\API\RequestData;
use App\UseCases\Product\AssignBasic;
use App\UseCases\Product\AssignDetail;
use App\UseCases\Product\AssignComposite;
use App\UseCases\Product\AssignVariation;

class GetProductDetail extends RequestData
{
    public function decideURLCall($value)
    {
        $url = env('API_URL');
        return $url .= '/'.$value;
    }

    public function formatData($data, $headers = null, $value = null, $type = 0)
    {
        $productDetail = new stdClass;
        if ($type === 0) {
            $productDetail = (new AssignComposite(new AssignVariation(new AssignDetail(new AssignBasic))))->setData($data, $productDetail);
        } else {
            $productDetail = (new AssignVariation(new AssignBasic))->setData($data, $productDetail);
        }
        return $productDetail;
    }
}
