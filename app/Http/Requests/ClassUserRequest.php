<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ClassUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'class_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],

            'period' => ['required'] //TODO: validate with regex
        ];
    }
}
