<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopdetailsController extends Controller
{
    public function index(){
        return view('frontend.shop-details');
    }
}
