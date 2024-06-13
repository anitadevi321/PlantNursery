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
        $this->categories = Categories::where('status', 1)->get();
       // $this->AllProducts = Product::paginate(5);
       $this->AllProducts = Product::where('status', 1)->limit(9)->get();
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

    
    
    public function index(Request $request)
    {

            return view('frontend.shop', [
                            'category_with_product' => $this->category_with_product,
                            'AllProductCount' => $this->AllProductCount,
                            'AllProducts' => $this->AllProducts,
                        ]);
    }

    public function fetch_single($id){
        $categories= categories::all();
        $products= product::where('category_id', $id)->get();
        return view('frontend.shop', compact('products', 'categories'));
    }

    public function fetchWithSorting($value)
    {
        if($value == 'ascWithName')
        {
            $ProductsWithSorting = Product::orderBy('name')->limit(9)->get();
            $data= [
                'ProductsWithSorting' => $ProductsWithSorting
            ];
            return response()->json($data);
        }
        else if($value == 'descWithName')
        {
            $ProductsWithSorting = Product::orderBy('name', 'desc')->limit(9)->get();
            $data= [
                'ProductsWithSorting' => $ProductsWithSorting
            ];
            return response()->json($data);
        }
        else if($value == 'ascWithNumarically')
        {
            $ProductsWithSorting = Product::orderBy('price')->limit(9)->get();
            $data= [
                'ProductsWithSorting' => $ProductsWithSorting
            ];
            return response()->json($data);
        }
        else if($value == 'descWithNumarically')
        {
            $ProductsWithSorting = Product::orderBy('price', 'desc')->limit(9)->get();
            $data= [
                'ProductsWithSorting' => $ProductsWithSorting
            ];
            return response()->json($data);
        }
    }


    public function getproduct (){
        //echo "hello";
        $data= [
            'category_with_product' => $this->category_with_product,
            'AllProductCount' => $this->AllProductCount,
            'AllProducts' => $this->AllProducts
        ];
        return response()->json($data);
    }

    public function fetchproduct_with_category($categoryId){
        $ProductsWithCategory= Product::where('category_id', $categoryId)->get();
        $data= [
            'ProductsWithCategory' => $ProductsWithCategory
        ];
        return response()->json($data);
    }
}
