<?php

namespace App;

class CartItem
{
    /**
     * @var $product Product
     */
    public  $product ;

    public  $qty ;

    /**
     * CartItem constructor.
     * @param Product $product
     * @param $qty
     */

    public function __construct(Product $product, $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
    }

}
