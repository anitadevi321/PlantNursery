<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   //stroe products in cart
   public function store(Request $request)
    {
        $productId = $request->productId;
        $product = Product::find($productId); // Ensure correct model name and import

        $qty = 1; // You might want to fetch quantity from $request if needed

        if (session()->has('user_login_id')) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $qty,
                'stock' => $product->stock,
            ]);
        return response()->json([
            'status' => true,
            'message' => 'add product in cart successfuly'
        ]);
        } else {
            $cart= [
                'product_id' => $productId,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $qty,
                'stock' => $product->stock,
            ];

            return response()->json([
                'status' => false,
                'data' => $cart
            ]);
        }
    
    }
   
   // check cart data
   public function checkCartData(Request $request)
    {
        if(session()->has('user_login_id'))
        {
            $userId = session('user_login_id'); // Fetch the user_login_id from session
            $cart = cart::where('user_id', $userId)->get(); // Using correct case for model name and variable
            
            return response()->json([
                'status' => true,
                'cart_data' => $cart
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    // view cart page
    public function index(){
        return view('frontend.cart');
     }

     
     // check quantity
     public function check_qty(Request $request)
     {
         $product = Product::find($request->productId);
        $stock = $product->stock;
     
         if ($request->qty <= $product->stock) {
             return response()->json([
                 "status" => true,
                 "total" => $stock
             ]);
         } else {
             return response()->json([
                 "status" => false,
                 "total" => $stock,
                 "message" => "Requested quantity is not available"
             ]);
         }
     }

     // update cart
     public function update_cart(Request $request)
     {
         $productId = $request->productId;
         $cartProduct = Cart::where('product_id', $productId)->get();

        $price= $cartProduct->price;
         if ($cartProduct) {
             $cartProduct->update([
                 'quantity' => $request->qty,
             ]);
     
             return response()->json([
                 'status' => true,
                 'message' => 'Cart updated successfully',
                 'price' => $price
             ]);
         } else {
             return response()->json([
                 'status' => false,
                 'message' => 'Product not found in cart'
             ]);
         }
     }
     
     
     // remove product into cart
     public function remove_product(Request $request){
        $productId= $request->productId;
        $cart= session::get('cart', []);

        if(isset($cart[$productId]))
        {
           unset($cart[$productId]);
           session::put('cart', $cart);

           return response()->json([
            'status' => true,
            'message' => 'product removed successfuly'
           ]);

        }else{
            return response()->json([
                'status' => false,
                'message' => 'product not in cart'
               ]);
        }
     }
}