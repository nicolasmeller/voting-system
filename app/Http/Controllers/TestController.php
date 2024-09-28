<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController
{
    public function getAuth(){

        return response('Hello World', 200)
        ->header('Content-Type', 'text/plain');
    }   
}
