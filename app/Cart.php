<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product ;
use App\CartItem ;
class Cart extends Model
{
    protected $fillable =[
        'cart_items','total','user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }


    public function increaseProductInCart(Product $product,$qty)
    {
        $cartItems = $this->cart_items;
        if(is_null($cartItems) || $cartItems ===[] )
        {
            $cartItems =[];
        }else{
            $cartItems = json_decode($cartItems);
        }
        /**
         * @var $cartItems CartItem
         */
        foreach ($cartItems as $cartItem){
            if($cartItem->product->id === $product->id){
                $cartItem->qty += $qty;
                $this->cart_items=json_encode($cartItems);

            }
        }
        $temporytotal=0;
        foreach ($cartItems as $cartItem){
            $temporytotal+=($cartItem->qty*$cartItem->product->price);

        }
        $this->total=$temporytotal;
    }
    public  function  addProductToCart(Product$product,$qty=1){

        $cartItems = $this->cart_items;
        if(is_null($cartItems) || $cartItems ===[] )
        {
            $cartItems =[];
        }else{
            $cartItems = json_decode($cartItems);
        }
        /**
         * @var  $cartItem CartItem
         */

        $cartItem=new CartItem($product,$qty);
        array_push($cartItems,$cartItem);
        $this->cart_items=json_encode($cartItems);
        $temporytotal=0;
        foreach ($cartItems as $cartItem){
            $temporytotal+=($cartItem->qty*$cartItem->product->price);

        }
        $this->total=$temporytotal;
        return $cartItems ;


    }

    public function  inItems($product_id){
        //TODO:CHECK IF THE PRODUCT IDIN ITEM

        $cartItems = $this->cart_items;
        if(is_null($cartItems) || $cartItems ===[] )
        {
            $cartItems =[];
            return false ;
        }else{
            $cartItems = json_decode($cartItems);
        }
        /**
         * @var  $cartItems CartItem
         */

        foreach ($cartItems as  $cartItem) {
            if ($product_id == $cartItem->product->id) {
                return true ;
            }
        }

        return false;

    }

}
