<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(){
        $rules = [
            'name' => 'required|unique:categories,name'
        ];
        return $rules;
    }
}