<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
            'email' => 'required|email',
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
    

  
    public function dashboardView()
    {
        return view('dashboard');
    }

    public function profile(){
        return view('users.profile');
    }

    public function update(Request $request){
        $request->validate([
            'password' => 'nullable|string|min:8|confirmed', // 'nullable' tillader at password kan være tomt
        ]);
            
        if($request->filled('password')){
            $request->password = Hash::make($request->password); 
        }


        Auth::User()->update(array_filter($request->all()));
    
        return redirect()->route('profile')->with('success', 'User have been updated!');
    }

}
