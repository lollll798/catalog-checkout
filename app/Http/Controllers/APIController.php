<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Traits\Hash;
use App\Contracts\CartItemInterface;
use App\UseCases\API\GetProductList;
use App\UseCases\API\GetProductDetail;
use App\UseCases\Cart\GetCartItems;
use App\Http\Controllers\NotificationController;

class APIController extends Controller
{
    use Hash;
    private $cartItem;
    private $getProductList;
    private $getProductDetail;
    private $getCartItem;
    private $notificationController;

    public function __construct(
        CartItemInterface $cartItem,
        GetProductList $getProductList,
        GetProductDetail $getProductDetail,
        GetCartItems $getCartItem,
        NotificationController $notificationController
    )
    {
        $this->cartItem = $cartItem;
        $this->getProductList = $getProductList;
        $this->getProductDetail = $getProductDetail;
        $this->getCartItem = $getCartItem;
        $this->notificationController = $notificationController;
    }

    public function requestCatalogList(Request $request)
    {
        $userID = 1;
        $page = $request->page?:1;
        $data = $this->getProductList->execute($page);
        $title = 'Catalogs';
        $cart = $this->cartItem->getCart($userID)[0];
        $cartCount = count($this->getCartItem->execute($cart['id']));
        $notificationCount = count($this->notificationController->getUnreadNotification());
        return View::make('catalogs.index', compact('data', 'title', 'cartCount', 'notificationCount'));
    }

    public function requestProductDetail(Request $request)
    {
        $productID = $this->decode($request->product_idx);
        $data = $this->getProductDetail->execute($productID);
        return View::make('catalogs.details.body', compact('data'));
    }

    public function getAllRawData() {
        for ($i=1; $i<13; $i++) {
            $request = new Request;
            $request->page = $i;
            $data = $this->requestCatalogList($request);
        }
    }

    public function getAllFormatedData() {
        for ($i=1; $i<13; $i++) {
            $request = new Request;
            $request->page = $i;
            $data = $this->requestCatalogList($request);
            foreach ($data['catalogLists'] as $product) {
                $productID = $this->decode($product->idx);
                dump($this->getProductDetail->execute($productID));
            }
        }
    }
}
