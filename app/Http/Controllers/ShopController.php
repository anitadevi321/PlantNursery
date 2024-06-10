<?php

namespace App\Http\Controllers;
use App\Models\categories;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $categories= categories::all();
        $products;
        // foreach($categories as $category)
        // {
        //     print_r($category);
        //     // dd($category);
        //     // $category_id= $category->id;
        //     // dd($category_id);
        //    //$products = product::where('category_id', $category_id)->count();
        // }
    
       return view('frontend.shop', compact('categories'));
    }

    public function fetch_single($id){
        $categories= categories::find($id);
        return view('frontend.shop', compact('categories'));
    }
}
