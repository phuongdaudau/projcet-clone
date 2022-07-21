<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function list(Request $request){
        $params = $request->all() ?? [];
        $carts = $this->cartService->addToCart($request, $params);
        $cartAuth = $this->cartService->getCart(Auth::id());
        return view('member.cart.list', compact('carts', 'cartAuth'));
    }
    
    public function saveQtyItemCart(Request $request, $id, $quanity){
        $this->cartService->saveQtyItemCart($request, $id, $quanity);
        $cartAuth = $this->cartService->getCart(Auth::id());
        return view('member.cart.list-cart-item', compact('cartAuth'));
    }

    public function deleteListCart(Request $request, $id){
        $this->cartService->deleteListCart($request, $id);
        $cartAuth = $this->cartService->getCart(Auth::id());
        return view('member.cart.list-cart-item', compact('cartAuth'));
    }
}
