<?php
namespace App\Models;

class Cart{
    public $products = null;
    public $totalPrice =0;
    public $totalQuantity =0;

    public function __construct($cart){
        if($cart){
            $this->products = $cart->products;
            $this->totalPrice = $cart->totalPrice;
            $this->totalQuantity = $cart->totalQuantity;
        }
    }

    public function addCart($product, $params){
        $newProduct = ['size' => '', 'color' => '', 'quantity' => 0, 'price'=> $product->price, 'productInfo' => $product];
        if($this->products){
            if(array_key_exists($params['id'], $this->products)){
                $newProduct = $this->products[$params['id']];
            }
        }
        $newProduct['size'] = $params['size'];
        $newProduct['color'] = $params['color'];
        $newProduct['quantity'] += $params['quantity'];;
        $newProduct['price'] = $newProduct['quantity'] * $product->price;
        $this->products[$params['id']] = $newProduct;
        $this->totalPrice += $product->price;
        $this->totalQuantity++;
    }

    public function deleteItemCart($id){
        $this->totalQuantity -=  $this->products[$id]['quantity'];
        $this->totalPrice -=  $this->products[$id]['price'];
        unset($this->products[$id]);
    }

    public function updateItemCart($id, $quantity){
        $this->totalQuantity -=  $this->products[$id]['quantity'];
        $this->totalPrice -=  $this->products[$id]['price'];

        $this->products[$id]['quantity'] = $quantity;
        $this->products[$id]['price'] =  $quantity * $this->products[$id]['productInfo']->price;

        $this->totalQuantity +=  $this->products[$id]['quantity'];
        $this->totalPrice +=  $this->products[$id]['price'];
    }
}