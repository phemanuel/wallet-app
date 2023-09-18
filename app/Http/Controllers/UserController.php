<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function register()
    {
        // Add your logic here for the registration process
        // For this example, we'll just return a basic view

        return view('pages.user-register');
    }

    public function login()
    {
        // Add your logic here for the registration process
        // For this example, we'll just return a basic view

        return view('pages.user-login');
    }
}
    
