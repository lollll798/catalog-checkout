<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

use App\Traits\Hash;
use App\Contracts\OrderPurchaseInterface;
use App\Contracts\CartItemInterface;
use App\UseCases\API\GetProductDetail;
use App\UseCases\Cart\GetCartItems;
use App\UseCases\Cart\AssignCartDetails;
use App\UseCases\OrderPurchase\GetFormatedDate;
use App\UseCases\OrderPurchase\EncodeOrderPurchase;
use App\UseCases\OrderPurchase\UpdateOrderPurchase;
use App\Http\Controllers\NotificationController;
class OrderPurchaseController extends Controller
{
    use Hash;
    private $userID;
    private $orderPurchase;
    private $cartItem;
    private $getCartItem;
    private $getProductDetail;
    private $updateOrderPurchase;
    private $notificationController;

    public function __construct(
        GetProductDetail $getProductDetail,
        OrderPurchaseInterface $orderPurchase,
        CartItemInterface $cartItem,
        GetCartItems $getCartItem,
        AssignCartDetails $assignCartDetails,
        GetFormatedDate $getFormatedDate,
        EncodeOrderPurchase $encodeOrderPurchase,
        UpdateOrderPurchase $updateOrderPurchase,
        NotificationController $notificationController
    ) {
        $this->userID = 1;
        $this->getProductDetail = $getProductDetail;
        $this->orderPurchase = $orderPurchase;
        $this->cartItem = $cartItem;
        $this->getCartItem = $getCartItem;
        $this->assignCartDetails = $assignCartDetails;
        $this->getFormatedDate = $getFormatedDate;
        $this->encodeOrderPurchase = $encodeOrderPurchase;
        $this->updateOrderPurchase = $updateOrderPurchase;
        $this->notificationController = $notificationController;
    }


    public function getOrderPurchase(Request $request)
    {
        $title = 'Purchase Orders';
        $data = $this->orderPurchase->getPOs($this->userID);
        $data = $this->encodeOrderPurchase->execute($data);
        $cart = $this->cartItem->getCart($this->userID)[0];
        $cartCount = count($this->getCartItem->execute($cart['id']));
        $notificationCount = count($this->notificationController->getUnreadNotification());
        return View::make('order-purchase.index', compact('data', 'title', 'cartCount', 'notificationCount'));
    }

    public function getOrderPurchaseDetails(Request $request)
    {
        $orderPurchaseID = $this->decode($request->idx);
        $cart = $this->cartItem->getCart($this->userID)[0];
        $po = $this->orderPurchase->getPO($orderPurchaseID);
        $po = $this->getFormatedDate->execute($po);
        $items = $this->getCartItem->execute($cart['id'], 1, $orderPurchaseID);
        $products = [];
        foreach ($items as $item) {
            $product = $this->getProductDetail->execute($item['product_id']);
            $products[] = $product;
        }
        $poItems = $this->assignCartDetails->execute($items, $products);
        return View::make('order-purchase.body', compact('po', 'poItems'));
    }

    public function orderPurchaseAction(Request $request)
    {
        $orderPurchaseID = $this->decode($request->idx);
        $status = $request->status;
        try {
            $this->updateOrderPurchase->execute($orderPurchaseID, $status);
            return Response::json(['success' => true]);
        } catch (\Exception $e) {
            return Response::json(['success' => false]);
        }
    }
}
