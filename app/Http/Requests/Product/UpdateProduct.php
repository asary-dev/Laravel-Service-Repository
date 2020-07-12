<?php

namespace App\Http\Requests\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class UpdateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_code' => "required|unique:products,product_code,{$this->product}",
            'product_price' => "required|numeric",
            'product_name' => 'required',
            'product_image'=> 'nullable|image|max:5120'
        ];
    }

    
}
