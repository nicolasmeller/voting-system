<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;


class UserController
{


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
