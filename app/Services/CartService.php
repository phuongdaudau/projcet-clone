<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Cart;

class CartService {
    
    public function getListProduct($request, $params){
        if(isset($params['product_id'])){
            $product = Product::where('id', $params['product_id'])->first();
            if($product != null){
                $oldCart = Session('Cart') ? Session('Cart') : null;
                $newCart = new Cart($oldCart);
                $newCart->addCart($product, $params['product_id']);

                $request->Session()->put('Cart', $newCart);
            }
        }
    }

    public function saveQtyItemCart($request, $id, $quanity){
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->updateItemCart($id, $quanity);
        $request->Session()->put('Cart', $newCart);
    }

    public function deleteListCart($request, $id){
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->deleteItemCart($id);
        if(Count($newCart->products) > 0){
            $request->Session()->put('Cart', $newCart);
        }else{
            $request->Session()->forget('Cart');
        }
    }

}