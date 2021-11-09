<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */

    public function showloginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == config('const.roles.admin')) {
                return redirect()->to('admin/student');
            } else if (Auth::user()->role_id == config('const.roles.teacher')) {
                return redirect()->to('teacher/attendance');
            } else if (Auth::user()->role_id == config('const.roles.student')) {
                return redirect()->to('student/class');
            }
        } else {
            return view('auth.login');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id == config('const.roles.admin')) {
                return redirect()->intended('admin/student');
            } else if (Auth::user()->role_id == config('const.roles.teacher')) {
                return redirect()->intended('teacher/attendance');
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
