<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AccountRequest extends FormRequest
{

    public function rules(Request $request)
    {
        $user = $this->account;

        $rules = [
            'username' => ['required', 'unique:users,username,'. $user],
        ];

        if (!empty($request->password)) {
            $rules['password'] = [
                'string',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/', // must contain a special character
            ];
        }

        return $rules;
    }
}
