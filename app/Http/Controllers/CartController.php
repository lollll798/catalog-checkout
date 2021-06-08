<?php

namespace App\Http\Controllers;


use App\Traits\Hash;

use App\Contracts\CartItemInterface;

use App\UseCases\API\GetProductDetail;
use App\UseCases\Cart\StoreCartItem;
use App\UseCases\Cart\StoreVariation;
use App\UseCases\Cart\StoreComponent;
use App\UseCases\Cart\GetCartItems;
use App\UseCases\Cart\AssignCartDetails;
use App\UseCases\Cart\CheckoutItem;
use App\UseCases\OrderPurchase\GeneratePONumber;
use App\UseCases\OrderPurchase\CreateOrderPurchase;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    use Hash;
    private $userID;
    private $cartItem;
    private $getProductDetail;
    private $storeCartItem;
    private $storeVariation;
    private $storeComponent;
    private $getCartItem;
    private $checkoutItem;
    private $generatePONumber;
    private $createOrderPurchase;

    public function __construct(
        CartItemInterface $cartItem,
        GetProductDetail $getProductDetail,
        StoreCartItem $storeCartItem,
        StoreVariation $storeVariation,
        StoreComponent $storeComponent,
        GetCartItems $getCartItem,
        AssignCartDetails $assignCartDetails,
        CheckoutItem $checkoutItem,
        GeneratePONumber $generatePONumber,
        CreateOrderPurchase $createOrderPurchase
    )
    {
        $this->userID = 1;
        $this->cartItem = $cartItem;
        $this->getProductDetail = $getProductDetail;
        $this->storeCartItem = $storeCartItem;
        $this->storeVariation = $storeVariation;
        $this->storeComponent = $storeComponent;
        $this->getCartItem = $getCartItem;
        $this->assignCartDetails = $assignCartDetails;
        $this->checkoutItem = $checkoutItem;
        $this->generatePONumber = $generatePONumber;
        $this->createOrderPurchase = $createOrderPurchase;
    }

    public function addToCart(Request $request)
    {
        $productID = $this->decode($request->idx);
        $qty = $request->qty;
        $variations = isset($request->variations)? $request->variations:[];
        $composites = isset($request->composites)? $request->composites:[];
        $variationDetails = isset($request->variation_details)? $request->variation_details:[];
        $compositeDetails = isset($request->composite_details)? $request->composite_details:[];

        try {
            $cart = $this->cartItem->getCart($this->userID)[0];
            $item = $this->storeCartItem->execute($cart['id'], $productID, $qty);
            $this->storeVariation->execute($item['id'], $variations, $variationDetails);
            $this->storeComponent->execute($item['id'], $composites, $compositeDetails);
            $count = count($this->getCartItem->execute($cart['id']));

            return Response::json(['success' => true, 'count' => $count]);
        } catch (\Exception $e) {
            return Response::json(['success' => false]);
        }
    }

    public function getCartDetails()
    {
        try {
            $cart = $this->cartItem->getCart($this->userID)[0];
            $items = $this->getCartItem->execute($cart['id']);
            $products = [];
            foreach ($items as $item) {
                $product = $this->getProductDetail->execute($item['product_id']);
                $products[] = $product;
            }
            $cartItems = $this->assignCartDetails->execute($items, $products);
            return View::make('carts.body', compact('cartItems'));
        } catch (\Exception $e) {
            return Response::json(['success' => false]);
        }
    }

    public function checkoutCart()
    {
        $cart = $this->cartItem->getCart($this->userID)[0];
        $items = $this->getCartItem->execute($cart['id']);
        if (count($items) == 0) {
            return Response::json(['success' => true, 'no_checkout' => true]);
        }
        try {
            $poNumber = $this->generatePONumber->execute($this->userID);
            $po = $this->createOrderPurchase->execute($poNumber, $this->userID);
            $this->checkoutItem->execute(array_column($items, 'id'), $po['id']);
            $count = count($this->getCartItem->execute($cart['id']));
            return Response::json(['success' => true, 'count' => $count]);
        } catch (\Exception $e) {
            return Response::json(['success' => false]);
        }

    }
}
