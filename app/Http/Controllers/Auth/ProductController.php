<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\product;

class ProductController extends Controller
{
    // show add category page
    public function index(){
        $categories = categories::all();
        return view('admin.product.add_product', compact('categories'));
    }

    // store products
    public function store(Request $request){
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

        try{
            $combinedMetaFields = [
                'meta_description' => $request->input('meta_description'),
                'meta_title' => $request->input('meta_title'),
            ];
            // Convert the combined fields array to JSON
            $combinedFieldsJson = json_encode($combinedMetaFields);

            if($validation->passes())
            {
                if($request->file('image') != '')
                {
                    //$imageName =  $request->file('image')->getClientOriginalName();
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move(public_path('upload_images/products'), $imageName);
                }

                $product= product::create([
                    'category_id' => $request->category,
                    'name' => $request->name,
                    "image" => $imageName,
                    'stock' => $request->stock,
                    'price' => $request->price,
                    'description'=> $request->description,
                    'status' => $request->status??0,
                    'meta' => $combinedFieldsJson, 
                ]);

                return redirect()->route('showProducts');
            }
           if($validation->fails())
           {
            return redirect()->route('addProduct')->withInput()->withErrors($validation);
           }
        }catch(\Exception $e){
            Log::error('Error adding product: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to add product. Please try again.']);
        }
            
    }

    // fetch all products 
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


        // show edit product page
        public function showEditProductapage($productId){
            try{
                $categories= categories::all();
                $product = Product::find($productId);
                return view('admin.product.edit_products', compact('product','categories'));
            }catch (\Exception $e) {
                Log::error('Error fetching product: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Failed to find the product. Please try again.']);
            }
            
        }

        
      // edit product
      public function editProduct(Request $request){
        $productId= $request->id;
        $validation = Validator::make($request->all(),[
            'category' => 'required',
            'name' => 'required|string',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_title' => 'required',
        ]);

        if($validation->passes())
        {
            $combinedMetaFields = [
                'meta_description' => $request->input('meta_description'),
                'meta_title' => $request->input('meta_title'),
            ];

            // Convert the combined fields array to JSON
            $combinedFieldsJson = json_encode($combinedMetaFields);

            $product= Product::find($productId);
            if($request->hasFile('image')){
                $oldpath= public_path('upload_images/products/' . $product->image);
                if (File::exists($oldpath)) {
                    File::delete($oldpath);
                    $imageName = time().'.'.$request->image->extension();
                   $request->image->move(public_path('upload_images/products'), $imageName);
                } 
            }
            else{
                $imageName= $product->image;
            }
            $product->update([
                'category_id' => $request->category,
                'name' => $request->name,
                "image" => $imageName,
                'stock' => $request->stock,
                'price' => $request->price,
                'description'=> $request->description,
                'status' => $request->status??0,
                'meta' => $combinedFieldsJson, 
            ]);
            return redirect()->route('showProducts');
        }
        if($validation->fails)
        {
            return redirect()->route('showProductEdit', '$productId')->withInput()->withErrors($credentials);
        }
    }

    // destroy product
    public function destroy($productId){
        try{
            $product= Product::find($productId);
            if($product)
            {
                $product->delete();
                return redirect()->route('showProducts');
            }
        }catch (\Exception $e) {
            Log::error('Error fetching product: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to find the product. Please try again.']);
        }
    }
}