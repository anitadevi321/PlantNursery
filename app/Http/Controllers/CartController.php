<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
   public function index(){
    return view('frontend.cart');
   }

   public function store(Request $request)
   {
      dd($request);
   }
}
