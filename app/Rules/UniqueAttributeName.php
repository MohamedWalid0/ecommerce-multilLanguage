<?php

namespace App\Rules;

use App\Models\AttributeTranslation;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttributeName implements Rule
{

    private $attributeName;
    private $attributeId;

    public function __construct($attributeName, $attributeId)
    {
        $this->attributeName = $attributeName;
        $this->attributeId = $attributeId;
    }

    
    public function passes($attribute, $value)
    {

        if($this -> attributeId) //edit form
            $attribute = AttributeTranslation::where('name', $value)->where('attribute_id','!=',$this->attributeId) -> first();
        else  //creation form
            $attribute = AttributeTranslation::where('name', $value)->first();

        if ($attribute)
            return false;
        else
            return true;

    }

  
    public function message()
    {
        return ' this name already exists  before';
    }
}
