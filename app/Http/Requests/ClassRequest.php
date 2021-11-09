<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ClassRequest extends FormRequest
{
    //check if authorized
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }
}
