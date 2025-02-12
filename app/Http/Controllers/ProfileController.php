<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Return profile view with user data
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $filename = time() . '_' . $profilePicture->getClientOriginalName();
            $path = $profilePicture->storeAs('profile_pictures', $filename, 'public');
            $user->profile_picture = $path; // Update the profile picture path directly
        }

        // Update other user fields
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function showVisitorsData(Request $request)
    {
        // Fetch data from Lumen API
        $response = Http::get('http://localhost:8000/fetch-visitors-data');  // Lumen endpoint to fetch visitors data
dd( $response);
        // Check if the request was successful
        if ($response->successful()) {
            $visitorsData = $response->json();
            // Return the data to the view or send a JSON response
            return view('profile.visitors', ['visitorsData' => $visitorsData]);
        }

        // Handle error if fetching data failed
        return view('profile.visitors', ['message' => 'Failed to fetch visitors data']);
    }
}
