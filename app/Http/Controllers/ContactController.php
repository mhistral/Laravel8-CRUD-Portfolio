<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{

    /**
     * Only Authenticated users can use this Page/Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('contact');
    }
}
