<?php

namespace App\UseCases\API;

use stdClass;
use App\UseCases\API\RequestData;
use App\UseCases\API\GenerateCatalogPage;
use App\UseCases\Product\AssignBasic;

class GetProductList extends RequestData
{
    private $generateCatalogPage;

    public function __construct(
        GenerateCatalogPage $generateCatalogPage
    )
    {
        $this->generateCatalogPage = $generateCatalogPage;
    }

    public function decideURLCall($selectedPage)
    {
        $url = env('API_URL');
        return $url .= '?page='.$selectedPage;
    }

    public function formatData($data, $headers, $selectedPage, $type = 0)
    {
        $totalItemsCount = (int)$headers['x-wp-total'][0];
        $totalPages = (int)$headers['x-wp-totalpages'][0];

        $catalogLists = $this->processCatalogList($data);
        $pageDetails = $this->generateCatalogPage->execute($totalItemsCount, $totalPages, $selectedPage);
        return compact('catalogLists', 'pageDetails');
    }

    private function processCatalogList($data)
    {
        $returnData = [];
        foreach ($data as $product) {
            $catalogItem = new stdClass;
            $catalogItem = (new AssignBasic())->setData($product, $catalogItem);
            array_push($returnData, $catalogItem);
        }
        return $returnData;
    }

}

