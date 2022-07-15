<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class cartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function list(Request $request){
        $params = $request->all() ?? [];
        $carts = $this->cartService->getListProduct($request, $params);
        return view('member.cart.list', compact('carts'));
    }
    
    public function saveQtyItemCart(Request $request, $id, $quanity){
        $this->cartService->saveQtyItemCart($request, $id, $quanity);
        return view('member.cart.list-cart-item');
    }
    public function deleteListCart(Request $request, $id){
        $this->cartService->deleteListCart($request, $id);
        return view('member.cart.list-cart-item');
    }
}
