<?php

namespace App\Http\Controllers;
use App\Models\categories;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $categories;
    protected $AllProducts;
    protected $AllProductCount;
    protected $category_with_product;
    
    public function __construct()
    {
        $this->categories = Categories::all();
        $this->AllProducts = Product::limit(9)->get();
        $this->AllProductCount = Product::count();

        $this->category_with_product = [];
        foreach ($this->categories as $category) {
            $products = Product::where('category_id', $category->id)->get();
            $this->category_with_product[] = [
                'category' => $category,
                'products' => $products,
                'product_count' => $products->count()
            ];
        }
    }

    public function index($cid = null, $value= null)
    {
        if ($cid !== null) {
            $AllProducts = Product::where('category_id', $cid)->limit(9)->get();
            return view('frontend.shop', [
                'category_with_product' => $this->category_with_product,
                'AllProductCount' => $this->AllProductCount,
                'AllProducts' => $AllProducts,
            ]);
        } else {
            // Return the view with the required data
            return view('frontend.shop', [
                'category_with_product' => $this->category_with_product,
                'AllProductCount' => $this->AllProductCount,
                'AllProducts' => $this->AllProducts,
            ]);
        }
    }
    

    public function fetch_single($id){
        $categories= categories::all();
        $products= product::where('category_id', $id)->get();
        return view('frontend.shop', compact('products', 'categories'));
    }

    public function fetchWithSorting($value)
    {
        if($value == 'Alphabetic_Asc')
        {
            $AllProducts = Product::orderBy('name')->limit(9)->get();
            return view('frontend.shop', [
                'category_with_product' => $this->category_with_product,
                'AllProductCount' => $this->AllProductCount,
                'AllProducts' => $AllProducts,
            ]);
        }
        else if($value == 'Alphabetic_desc')
        {
            $AllProducts = Product::orderBy('name', 'desc')->limit(9)->get();
            return view('frontend.shop', [
                'category_with_product' => $this->category_with_product,
                'AllProductCount' => $this->AllProductCount,
                'AllProducts' => $AllProducts,
            ]);
        }
        else if($value == 'Numarically_Asc')
        {
            $AllProducts = Product::orderBy('price')->limit(9)->get();
            return view('frontend.shop', [
                'category_with_product' => $this->category_with_product,
                'AllProductCount' => $this->AllProductCount,
                'AllProducts' => $AllProducts,
            ]);
        }
        else if($value == 'Numarically_desc')
        {
            $AllProducts = Product::orderBy('price', 'desc')->limit(9)->get();
            return view('frontend.shop', [
                'category_with_product' => $this->category_with_product,
                'AllProductCount' => $this->AllProductCount,
                'AllProducts' => $AllProducts,
            ]);
        }
        
    }
}
