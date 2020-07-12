<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrder extends FormRequest
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
            'customer_name' => "required",
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'product_id' => 'required',
            'quantity' => 'min:1|numeric',
            'total' => 'required',
        ];
    }

    
}
