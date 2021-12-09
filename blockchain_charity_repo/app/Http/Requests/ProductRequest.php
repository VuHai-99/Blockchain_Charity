<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'product_name' => 'required|unique:products,product_name,NULL,id,deleted_at,NULL',
            'image' => 'required|mimes:jpg,png,jpeg',
            'quantity' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ];

        if ($this->id) {
            $rules['product_name'] = 'required|unique:products,product_name,' . $this->id . ',id,deleted_at,NULL';
            $rules['image'] = '';
        }
        return $rules;
    }
}