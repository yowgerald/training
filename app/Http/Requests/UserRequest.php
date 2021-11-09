<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    //check if authorized
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $user = $this->student ?? $this->teacher;

        $rules = [
            'physical_id' => ['required', 'numeric', 'unique:users,physical_id,'. $user],
            'first_name' => ['required'],
            'last_name' => ['required']
        ];

        if ($request->role_id == config('const.roles.teacher')) {
            $rules['title'] = ['required'];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'physical_id' => 'ID'
        ];
    }
}
