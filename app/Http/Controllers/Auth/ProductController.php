<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\product;

class ProductController extends Controller
{
    // show add category page
    public function index(){
        $categories = categories::all();
        //return view('your-view-name', compact('categories'));
        return view('admin.product.add_product', compact('categories'));
    }

    // store products
    public function store(Request $request){
        //dd($request);
        $validation = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required|string',
            'image' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_title' => 'required',
        ]);
                $combinedMetaFields = [
                    'meta_description' => $request->input('meta_description'),
                    'meta_title' => $request->input('meta_title'),
                ];

                // Convert the combined fields array to JSON
                $combinedFieldsJson = json_encode($combinedMetaFields);

                if($validation->passes())
                {
                    $product= product::create([
                        'category_id' => $request->category,
                        'name' => $request->name,
                        "image" => $request->file('image')->getClientOriginalName(),
                        'stock' => $request->stock,
                        'price' => $request->price,
                        'description'=> $request->description,
                        'status' => $request->status??0,
                        'meta' => $combinedFieldsJson, 
                    ]);
                }
               if($validation->fails())
               {
                return redirect()->route('addProduct')->withInput()->withErrors($validation);
               }
    }

    public function show_products()
    {
        $products = Product::all();
        $categoryNames = [];
        foreach ($products as $product) {
            $category = categories::find($product->category_id);
            if ($category) {
                // Store the category name in the array, indexed by category ID
                $categoryNames[$product->category_id] = $category->name;
            }
        }
        return view('admin.product.show_product', compact('products', 'categoryNames'));
    }

    public function destroy($productId){
        $product= Product::find($productId);
        if($product)
        {
            $product->delete();
            return redirect()->route('showProducts');
        }
    }


    public function showProductapage($productId){
        $categories= categories::all();
        $product = Product::find($productId);
        return view('admin.product.edit_products', compact('product','categories'));
    }

    public function editProduct(Request $request){
        $productId= $request->id;
        $validation = Validator::make($request->all(),[
            'category' => 'required',
            'name' => 'required|string',
            'image' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_title' => 'required',
        ]);

        if($validation->fails)
        {
            return redirect()->route('showProductEdit', '$productId')->withInput()->withErrors($credentials);
        }
    }
}