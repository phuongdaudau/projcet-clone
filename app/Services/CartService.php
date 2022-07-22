<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Color;
use App\Models\MainCart;
use App\Models\Size;
use App\Models\Member;
use Illuminate\Support\Facades\Session;

class CartService {
    
    public function addToCart($request, $params){
        if(isset($params['product_id'])){
            $product = Product::where('id', $params['product_id'])->first();
            $color = Color::where('id', $params['color_id'])->first();
            $size = Size::where('id', $params['color_id'])->first();
            $data['id'] = $params['product_id'];
            $data['color'] = $color->name;
            $data['size'] = $size->name;
            $data['quantity'] = $params['quantity'];

            if (auth('web')->user()){
                $data['member_id'] = auth('web')->id();
                $this->checkAndInsert($data);
            }
            else
            {
                if($product != null){
                    $oldCart = Session('Cart') ? Session('Cart') : null;
                    $newCart = new Cart($oldCart);
                    $newCart->addCart($product, $data);
                    $request->Session()->put('Cart', $newCart);
                }
            }
        }
    }

    public function insertCartIfAuthentication($request){
        if (Session::get('Cart') != null){
            $email = $request->only('email');
            $member = Member::where('email', $email)->first();
            foreach (Session::get('Cart')->products as $product_id => $item){
                $data['id'] = $product_id;
                $data['color'] = $item['color'];
                $data['size'] = $item['size'];
                $data['quantity'] = $item['quantity'];
                $data['member_id'] = $member->id;
                $this->checkAndInsert($data);
            }
            $request->Session()->forget('Cart');
        }
    }

    public function checkAndInsert($data){
        $flagCheck = $this->checkDuplicate($data);
        if(!$flagCheck){
            MainCart::create([
                'product_id' => $data['id'],
                'member_id' => $data['member_id'],
                'color' => $data['color'],
                'size' =>$data['size'],
                'quantity' => $data['quantity']
            ]);
        }else{
            $product = MainCart::where('product_id', $data['id'])
                                ->where('member_id', $data['member_id'])
                                ->where('color', $data['color'])
                                ->where('size', $data['size'])->first();
            $product->update(['quantity'=> $product->quantity + $data['quantity']]);
        }
    }

    public function checkDuplicate($data){
        $carts = MainCart::get();
        $flag = false;
        foreach ($carts as $item){
            if($item->product_id == $data['id'] && $item->member_id = $data['member_id'] 
            && $item->color == $data['color'] && $item->size == $data['size'])
            {
                $flag = true;
            }else{
                $flag = false;
            }
        }
        return $flag;
    }
    
    public function checkDuplicate2($data){
        $carts = MainCart::get();
        $flag = false;
        foreach ($carts as $item){
            if($item->member_id = Auth::id() && $item->product_id == $data['id'] 
            && $item->color == $data['color'] && $item->size == $data['size'])
            {
                $flag = true;
            }else{
                $flag = false;
            }
        }
        return $flag;
    }


    public function saveQtyItemCart($request, $id, $quanity){
        if(auth('web')->user()){
            MainCart::where('product_id', $id)->update(['quantity'=> $quanity]);
        }else{
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->updateItemCart($id, $quanity);
            $request->Session()->put('Cart', $newCart);
        }
    }

    public function deleteListCart($request, $id){
        if(auth('web')->user()){
            MainCart::where('product_id', $id)->delete();
        }else{
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

    public function getCart($id){
        return MainCart::where('member_id', $id)->get();
    }

    public function insertCart($data){
        MainCart::create([
            'product_id' => $data['id'],
            'member_id' => Auth::id(),
            'color' => $data['color'],
            'size' =>$data['size'],
            'quantity' => $data['quantity']
        ]);
    }

    public function saveCartAjax($data)
    {
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                    $qty = $cart[$key]['product_qty'];
                    $cart[$key]['product_qty'] = (int)$qty + 1;
                }
                Session::put('cart', $cart);
            }
            if($is_avaiable == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['cart_product_id'],
                    'product_size' => $data['cart_product_size'] ?? 'S',
                    'product_color' => $data['cart_product_color'] ?? 'Black',
                    'product_qty' => $data['cart_product_qty'],
                    'product_name' => $data['cart_product_name'],
                    'product_image' => $data['cart_product_image'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_size' => $data['cart_product_size'] ?? 'S',
                'product_color' => $data['cart_product_color'] ?? 'Black',
                'product_qty' => $data['cart_product_qty'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_price' => $data['cart_product_price'],
            );
            Session::put('cart',$cart);
        }
        Session::save();
    }

    public function deleteCartAjax($data)
    {
        $cart = Session::get('cart');
        $session_id = $data['cart_product_id'];
        $user = auth('web')->user();
        if($cart==true){
            foreach($cart as $key => $val){
                if($user){
                    $product = MainCart::where('product_id' ,$val['product_id'])
                        ->where('member_id', $user->id)->first();
                    if($product){
                        $product->delete();
                    }
                }
                if($val['session_id']== $session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
           return true;
        }else{
            return false;
        }
    }

    public function updateCartAjax($data)
    {
        $cart = Session::get('cart');
        if($cart==true){
            foreach($cart as $session => $val){
                if($val['session_id']== $data['cart_product_id']){
                    $cart[$session]['product_qty'] = $data['cart_product_qty'];
                }
            }
            Session::put('cart',$cart);
            return $data['cart_product_qty'];
        }
        return 0;
    }

    public function deleteAllCart()
    {
        Session::forget('cart');
    }

    public function saveCartUser($back = true)
    {
       $user = auth('web')->user();
       $cart = Session::get('cart');
       foreach($cart as $key => $val){
            MainCart::updateOrCreate(
                [
                    'product_id' => $val['product_id'],
                    'member_id' => $user->id,
                ],
                [
                    'color' => $val['product_color'],
                    'size' =>$val['product_size'],
                    'quantity' => $val['product_qty']
                ]
            );
       }
       if($back){
        return redirect()->route('show_cart_ajax');
       }
       return redirect()->route('cart_ajax');
    }

    public function saveCartUserAjax()
    {
        $user = auth('web')->user();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        if ($user) {
            $cartsUser = MainCart::with('product')->where('member_id', $user->id)->get()->toArray();
            foreach ($cartsUser as $key => $cartUser) {
                $images = explode(',', $cartUser['product']['images']);
                $cart = Session::get('cart');
                if ($cart) {
                    $is_avaiable = 0;
                    foreach ($cart as $key => $val) {
                        $productID = $val['product_id'];
                        if ($productID == $cartUser['product_id']) {
                            $is_avaiable++;
                            $qty = $cart[$key]['product_qty'];
                            $cart[$key]['product_qty'] = (int)$qty + 1;
                        }
                        Session::put('cart', $cart);
                    }
                    if ($is_avaiable == 0) {
                        $cart[] = array(
                            'session_id' => $session_id,
                            'product_id' => $cartUser['product_id'],
                            'product_size' => $cartUser['size'] ?? 'S',
                            'product_color' => $cartUser['color'] ?? 'Black',
                            'product_qty' => $cartUser['quantity'],
                            'product_name' => $cartUser['product']['name'],
                            'product_image' => $images[1],
                            'product_price' => $cartUser['product']['price'],
                        );
                        Session::put('cart', $cart);
                    }
                } else {
                    $cart[] = array(
                        'session_id' => $session_id,
                        'product_id' => $cartUser['product_id'],
                        'product_size' => $cartUser['size'] ?? 'S',
                        'product_color' => $cartUser['color'] ?? 'Black',
                        'product_qty' => $cartUser['quantity'],
                        'product_name' => $cartUser['product']['name'],
                        'product_image' => $images[1],
                        'product_price' => $cartUser['product']['price'],
                    );
                    Session::put('cart', $cart);
                }
                Session::save();
            }
        }
    }

    public function deleteAllCartUser()
    {
        $cart = Session::get('cart');
        $user = auth('web')->user();
        if($cart==true){
            foreach($cart as $key => $val){
                if($user){
                    $product = MainCart::where('product_id' ,$val['product_id'])
                        ->where('member_id', $user->id)->first();
                    if($product){
                        $product->delete();
                    }
                }
            }
           return $this->deleteAllCart() ;
        }else{
            return false;
        }
    }
}