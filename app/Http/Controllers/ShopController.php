<?php

namespace App\Http\Controllers;
use App\Models\categories;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $categories;
    //protected $AllProducts;
    protected $AllProductCount;
    protected $category_with_product;
    
    public function __construct()
    {
        $this->categories = Categories::where('status', 1)->get();
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
    
    // fetch all products
    public function index(Request $request)
    {
       $AllProducts = Product::where('status', 1)->paginate(6);
            return view('frontend.shop', [
                            'category_with_product' => $this->category_with_product,
                            'AllProductCount' => $this->AllProductCount,
                            'AllProducts' => $AllProducts
                        ]);
    }

    // fetch products with filter
    public function getproduct ($value= null){
        if(isset($value))
        {
            if(is_numeric($value))
            {
               $categoryId= $value;
                $productsWithCategory = Product::where('category_id', $categoryId)->paginate(2);

                return response()->json([
                    'products' => $productsWithCategory,
                    'paginationLinks' => $productsWithCategory->links()->toHtml()
                ]);
            }
            else if(is_string($value)){
                if($value == 'ascWithName')
                {
                    $ProductsWithSorting = Product::orderBy('name')->paginate(6);
                 
                    return response()->json([
                        'products' => $ProductsWithSorting,
                        'paginationLinks' => $ProductsWithSorting->links()->toHtml()
                    ]);
                }
                else if($value == 'descWithName'){
                    $ProductsWithSorting = Product::orderBy('name', 'desc')->paginate(6);
                    return response()->json([
                        'products' => $ProductsWithSorting,
                        'paginationLinks' => $ProductsWithSorting->links()->toHtml()
                    ]);
                }
                else if($value == 'ascWithNumarically'){
                    $ProductsWithSorting = Product::orderBy('price')->paginate(6);
                    return response()->json([
                        'products' => $ProductsWithSorting,
                        'paginationLinks' => $ProductsWithSorting->links()->toHtml()
                    ]);
                }
                else if($value == 'descWithNumarically'){
                    $ProductsWithSorting = Product::orderBy('price', 'desc')->paginate(6);
                    return response()->json([
                        'products' => $ProductsWithSorting,
                        'paginationLinks' => $ProductsWithSorting->links()->toHtml()
                    ]);
                }
            }
        }
        else{
            $AllProducts = Product::where('status', 1)->paginate(6);
            $data= [
                'AllProducts' => $AllProducts,
            ];
            return response()->json($data);
        }
    }
}