<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\categories;
class ShopdetailsController extends Controller
{
    public function index($id){
        // Find the product by its ID
        $product = Product::find($id);
        $category_id= $product->category_id;
       
        $category_name= categories::where('id', $category_id)->pluck('name');
        // Pass the product data to the view
        return view('frontend.shop-details', compact('product', 'category_name'));
    }

}
