<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public  function  index(){
        $user=Auth::user();
        $cart=$user->cart;
        $cartItems=json_decode($cart->cart_items);
        $finaCartItems=[];
        foreach ($cartItems as $cartItem){
            $product=Product::find(intval($cartItem->product->id));
            $finaCartItem=new \stdClass();
            $finaCartItem->product=new ProductResource($product);
            $finaCartItem->qty=number_format(doubleval($cartItem->qty),2);
            array_push($finaCartItems,$finaCartItem);
        }
        return [
            'cart_items'=>$finaCartItems,
            'id'=>$cart->id,
            'total'=>$cart->total
        ];
    }
    public function addProductToCart(Request $request){
        $request->validate([
           'product_id' => 'required',
           'qty' => 'required'
        ]);
        /**
         *
         */

        $user=Auth::user();
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');
        $product=Product::findOrFail($product_id);
        /**
         * @var $cart Cart
         */
        $cart = $user->cart;
        if(is_null($cart)){
            $cart = new Cart();
            $cart->cart_items =[];
            $cart->user_id =Auth::user()->id ;
            $cart->total=0;

        }


        if($cart->inItems($product->id)){
            $cart->increaseProductInCart($product,$qty);
        }else{
            $cart->addProductToCart($product,$qty);
        }
        $cart->save();
        $user->cart->id = $cart->id ;
        $user->save();
        return $cart ;

    }

}
