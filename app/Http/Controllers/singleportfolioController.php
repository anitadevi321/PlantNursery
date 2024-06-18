<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class singleportfolioController extends Controller
{
    public function index(){
        return view('frontend.single-portfolio');
    }
}
