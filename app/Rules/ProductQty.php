<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductQty implements Rule
{
    private $manage_stock;
   

    public function __construct($manage_stock)
    {
        $this -> manage_stock = $manage_stock;

    }

  
    public function passes($attribute, $value)
    {
        if($this -> manage_stock == 1 &&  $value == null )
            return false;
        else
            return true;

    }

    public function message()
    {
        return ' the quantity must have value when manage stock equal 1 .';
    }
}
