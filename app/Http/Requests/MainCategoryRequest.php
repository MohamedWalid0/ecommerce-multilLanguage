<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'slug' => 'required|unique:categories,slug,'. $this -> id
       ];
   }
}
