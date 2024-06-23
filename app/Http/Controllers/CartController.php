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
      $total= cart::count();
      return view('frontend.cart', compact('cart'));
     }
}