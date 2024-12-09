<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:staff'); // Protect all methods in this controller
    }

    public function index()
    {
        $staff = User::all();
        return view('staff.index', compact('staff'));
    }

    // Show the form to create a new staff member
    public function create()
    {
        return view('staff.create');
    }

    // Store a new staff member
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully!');
    }

    // Show the form to edit a staff member
    public function edit($id)
    {
        $staff = User::findOrFail($id);
        return view('staff.edit', compact('staff'));
    }

    // Update the staff member details
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $id,
            'role' => 'required|string',
        ]);

        $staff = User::findOrFail($id);
        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $staff->password,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully!');
    }

    // Delete a staff member
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully!');
    }
}
