<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\product;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
   //stroe products in cart
   public function store(Request $request)
   {
       $product_id = $request->product_id;
       $product = Product::find($product_id); // Ensure correct model name capitalization
       $qty = 1;
   
       // Retrieve cart from session
       $cart = $request->session()->get('cart', []);
   
       if (isset($cart[$product_id])) {
           return redirect()->route('cart')->with('message', 'Product already in cart');
       } else {
           if ($product->status == 1 && $product->stock >= 1) {
               // Add product to cart
               $cart[$product_id] = [
                   'qty' => $qty,
                   'name' => $product->name,
                   'image' => $product->image,
                   'price' => $product->price,
                   'stock' => $product->stock
               ];
   
               // Store updated cart in session
               $request->session()->put('cart', $cart);
   
               return redirect()->route('cart')->with('message', 'Product added to cart successfully');
           } else {
               return redirect()->back()->with('error', 'Product out of stock');
           }
       }
   }
   
   // show cart page
   public function index(Request $request){
      $cart= $request->session()->get('cart', []);

      $totalItems= 0;
      $totalprice= 0;
      foreach($cart as $item){
        $totalItems += $item['qty'];
        $totalprice += $item['qty'] * $item['price'];
      }
      return view('frontend.cart', compact('cart', 'totalItems', 'totalprice'));
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
         $cart = Session::get('cart', []);
         $productId = $request->input('productId');
         $qty = $request->input('qty');
     
         if (isset($cart[$productId])) {
             // Update the quantity
             $cart[$productId]['qty'] = $qty;
     
             // Retrieve the price from session
            
             $price = isset($cart[$productId]['price']) ? $cart[$productId]['price'] : null;
             $totalItems= 0;
            $totalprice= 0;
            foreach($cart as $item){
                $totalItems += $item['qty'];
                $totalprice += $item['qty'] * $item['price'];
            }
             // Update the cart in the session
             Session::put('cart', $cart);
            
             return response()->json([
                 'status' => true,
                 'message' => 'Cart updated successfully',
                 'cart' => $cart,
                 'price' => $price,
                 'totalItems' => $totalItems
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