<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(){
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id'
        ];
        return $rules;
    }
}