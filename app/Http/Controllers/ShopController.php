<?php

namespace App\Http\Controllers;
use App\Models\categories;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index($id = null){
        $categories= categories::all();
        $category_id= $categories->pluck('id');

        $products= product::whereIn('category_id', $category_id)->get();
        // return view('frontend.shop', compact('categories', 'products'));

        if(isset($id))
        {
            $productWithCategory= product::where('category_id', $id)->get();
            return view('frontend.shop', compact('products', 'categories', 'productWithCategory'));
        }
        else{
        // $categories= categories::all();
        // $category_id= $categories->pluck('id');

        // $products= product::whereIn('category_id', $category_id)->get();
        return view('frontend.shop', compact('categories', 'products'));
        }
    }

    public function fetch_single($id){
        $categories= categories::all();
        $products= product::where('category_id', $id)->get();
        return view('frontend.shop', compact('products', 'categories'));
    }
}
