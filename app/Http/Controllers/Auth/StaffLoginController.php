<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffLoginController extends Controller
{
    public function __construct()
    {
       // $this->middleware('guest:staff')->except('logout');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::guard('staff')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        } else {
            return redirect()->route('staff.login')->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        return redirect()->route('staff.login');
    }
}
