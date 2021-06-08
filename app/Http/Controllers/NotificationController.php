<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use App\Traits\Hash;
use App\Traits\Timestamp;
use App\Models\User;
use App\Events\NotificationEvent;
use App\Contracts\CartItemInterface;
use App\Contracts\OrderPurchaseInterface;
use App\UseCases\Cart\GetCartItems;
use App\UseCases\API\GetProductDetail;
use App\UseCases\Cart\AssignCartDetails;
use App\UseCases\OrderPurchase\GetFormatedDate;
use App\UseCases\OrderPurchase\UpdateOrderPurchase;
use App\UseCases\Notification\CreateNotification;

class NotificationController extends Controller
{
    use Hash;
    use Timestamp;
    private $userID;
    private $updateOrderPurchase;
    private $getProductDetail;
    private $orderPurchase;
    private $cartItem;
    private $getFormatedDate;
    private $getCartItem;
    private $assignCartDetails;

    public function __construct(
        GetProductDetail $getProductDetail,
        OrderPurchaseInterface $orderPurchase,
        CartItemInterface $cartItem,
        GetCartItems $getCartItem,
        GetFormatedDate $getFormatedDate,
        AssignCartDetails $assignCartDetails,
        UpdateOrderPurchase $updateOrderPurchase,
        CreateNotification $createNotification
    ) {
        $this->userID = 1;
        $this->updateOrderPurchase = $updateOrderPurchase;
        $this->createNotification = $createNotification;
        $this->getProductDetail = $getProductDetail;
        $this->getFormatedDate = $getFormatedDate;
        $this->orderPurchase = $orderPurchase;
        $this->cartItem = $cartItem;
        $this->getCartItem = $getCartItem;
        $this->assignCartDetails = $assignCartDetails;
    }

    public function getUserNotification()
    {
        $user = User::find($this->userID);
        $result = $user->notifications->toArray();
        $notifications = [];
        foreach ($result as $key => $notification) {
            $notification['data']['idx'] = $this->encode($notification['data']['order_purchase_id']);
            $notification['formated_datetime'] = $this->formatDateTime($notification['created_at'], 3, 1);;
            array_unshift($notifications, $notification);
        }
        $this->markNotificationAsRead();
        return View::make('notification.body', compact('notifications'));
    }

    public function getUnreadNotification()
    {
        $user = User::find($this->userID);
        return $user->unreadNotifications->toArray();
    }

    public function markNotificationAsRead()
    {
        $user = User::find($this->userID);
        $user->unreadNotifications->markAsRead();
        $user->unreadNotifications()->update(['read_at' => Carbon::now()]);
        return Response::json(['success' => true]);
    }

    public function generateNotification(Request $request)
    {
        $orderPurchaseID = $request->idx;
        $status = 3;
        $idx = $this->encode($orderPurchaseID);
        $this->updateOrderPurchase->execute($orderPurchaseID, $status);
        $this->createNotification->execute($this->userID, $orderPurchaseID);
        event(new NotificationEvent(count($this->getUnreadNotification()), $idx));

        return Response::json(['success' => true]);
    }

    public function viewOrderPurchase(Request $request)
    {
        $user = User::find($this->userID);
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
}
