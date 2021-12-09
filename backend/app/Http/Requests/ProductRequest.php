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
        return [
            'product'=>'required|unique:product,name',
            'image' => 'required',
            // 'image.*'=>'image|mimes:jpeg,jpg,png,gif',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product.required'     => 'Sản phẩm không được để trống.',
            'product.unique:product'     => 'Tên sản phẩm không được trùng',
            'image.required'  => 'Hình ảnh không được để trống.',
            // 'image.*.mimes'     => 'Không phải file ảnh: file ảnh là: jpg, png, gif, jpeg.',
        ];
    }
}
