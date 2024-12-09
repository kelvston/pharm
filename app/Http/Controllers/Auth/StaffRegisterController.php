<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;

class StaffRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.register')
                ->withErrors($validator)
                ->withInput();
        }

        Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('staff.login')->with('success', 'Registration successful! Please log in.');
    }
}
