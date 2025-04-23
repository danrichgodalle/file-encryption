<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // Show the signup form
    public function showSignupForm()
    {
        return view('signup'); // Ensure the view file is in the correct location
    }

    // Handle registration logic
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new client
        Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to the home page with a success message
        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    // Show the signin form
    public function showSigninForm()
    {
        return view('signin'); // Ensure the view file is in the correct location
    }

    // Handle login logic
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Get the credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to log in the client
        if (Auth::guard('client')->attempt($credentials)) {
            return redirect()->route('client.dashboard'); // Redirect to the dashboard
        }

        // Return back with an error message if login fails
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Show the client dashboard
    public function dashboard()
    {
        return view('clients.dashboard'); // Updated to match the folder structure
    }
}