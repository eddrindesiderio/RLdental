<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class SignupController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        // Validate the request data
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'number' => ['required', 'regex:/^09\d{9}$/'], // Ensure it's a valid Philippine mobile number
            'address' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'after_or_equal:1950-01-01'],
            'password' => [
                'required',
                'confirmed',
                'min:9',
                'regex:/[A-Z]/',       // At least one uppercase letter
                'regex:/[!@#$%^&*]/', // At least one special character
                'size:9',            // Exactly 10 characters
            ],
        ], [
            'number.regex' => 'The mobile number must start with 09 and be exactly 11 digits.',
            'dob.after_or_equal' => 'Date of Birth must not be before 1950.',
            'password.regex' => 'Password must contain at least 1 uppercase letter and 1 special character.',
            'password.size' => 'Password must be exactly 8 characters long.',
        ]);

        // Create the user with a default 'inactive' status
        $user = User::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'number' => $request->input('number'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'userRole' => 'patient',
            'password' => Hash::make($request->input('password')),
            'status' => 'inactive',
        ]);

        // Trigger registration event for email verification
        if ($user) {
            event(new Registered($user));
            return redirect()->route('signin')->with('success', 'You are registered! Please verify your email.');
        }

        // If user creation failed
        return redirect()->route('signup')->with('error', 'Failed to create user.');
    }
}
