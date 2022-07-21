<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Color;
use App\Models\MainCart;
use App\Models\Size;
use Illuminate\Support\Facades\Auth;
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
            
            if (Auth::check()){
                if (Session::get('Cart') != null){
                    foreach (Session::get('Cart')->products as $product_id => $item){
                        $cart = MainCart::create([
                            'product_id' => $product_id,
                            'member_id' => Auth::id(),
                            'color' => $item['color'],
                            'size' =>$item['size'],
                            'quantity' => $item['quantity']
                        ]);
                    }
                    $request->Session()->forget('Cart');
                }
                else
                {
                    $flagCheck = $this->checkDuplicate($data);
                    if($flagCheck){
                        $product = MainCart::where('product_id', $data['id'])
                                            ->where('member_id', Auth::id())
                                            ->where('color', $data['color'])
                                            ->where('size', $data['size'])->first();
                        $product->update(['quantity'=> $product->quantity + $data['quantity']]);
                    }else{
                        $this->insertCart($data);
                    }
                }
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

    public function saveQtyItemCart($request, $id, $quanity){
        if(Auth::check()){
            MainCart::where('product_id', $id)->update(['quantity'=> $quanity]);
        }else{
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->updateItemCart($id, $quanity);
            $request->Session()->put('Cart', $newCart);
        }
    }

    public function deleteListCart($request, $id){
        if(Auth::check()){
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

    public function checkDuplicate($data){
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

}