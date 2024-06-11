<?php

namespace App\Http\Controllers;
use App\Models\categories;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index($cid = null)
    {
        // Get all categories
        $categories = Categories::all();
        
        // Get a limited number of products (9 in this case)
        $AllProducts = Product::limit(9)->get();
        
        // Get the total count of all products
        $AllProductCount = Product::count();
        
        // Prepare an array to hold categories with their respective products
        $category_with_product = [];
    
        foreach ($categories as $category) {
            $products = Product::where('category_id', $category->id)->get();
            $category_with_product[] = [
                'category' => $category,
                'products' => $products,
                'product_count' => $products->count()
            ];
        }
    
        // If a specific category ID is provided, filter products by that category
        if ($cid !== null) {
            $AllProducts = Product::where('category_id', $cid)->limit(9)->get();
            return view('frontend.shop', compact('category_with_product', 'AllProductCount', 'AllProducts'));
        }
    
        // Return the view with the required data
        return view('frontend.shop', compact('category_with_product', 'AllProductCount', 'AllProducts'));
    }
    

    public function fetch_single($id){
        $categories= categories::all();
        $products= product::where('category_id', $id)->get();
        return view('frontend.shop', compact('products', 'categories'));
    }
}
