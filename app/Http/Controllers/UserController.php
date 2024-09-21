<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function registerView()
    {
        return view('users.register');
    }
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);


       User::create([
        'name' => $request->get('name'),
        'last_name' => $request->get('last_name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
       ]);
       
       return redirect()->route('login')->with('success', 'User created successfully! You can now log in!');
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully!');
    }

    public function loginView()
    {
        return view('users.login');
    }


    public function login(Request $request)
    {
        // Validér login data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Authentificer brugeren
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication var vellykket
            return redirect()->intended('dashboard')->with('success', 'Logged in successfully!'); // Skift til ønsket rute
        }

        // Authentication fejlede
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboardView()
    {
        return view('users.dashboard');
    }

}
