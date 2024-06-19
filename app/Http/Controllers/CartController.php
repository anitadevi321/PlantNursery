<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\product;
class CartController extends Controller
{
  
   public function store(Request $request)
   {
      $qty = $request->qty ?? 1;
      $product= product::find($request->product_id);
     $productAllreadyExist= false;
      if(Cart::count() > 0)
      {
         $cartcontent= cart::content();
         //echo $cartcontent->id;die;
         foreach($cartcontent as $item){
            if($item->id == $request->product_id)
            {
               $productAllreadyExist= true;
               echo "product already in cart";
            }
         }
      }
         if($productAllreadyExist == false)
         {
            Cart::add([
               'id' => $request->product_id,
               'name' => $product->name,
               'qty' => $qty,
               'price' => $product->price,
               'attributes' => [
                   'image' => $product->image, // Assuming 'image_url' is the attribute storing the image URL
               ],
               'weight' => 550,
           ]);
           

        // Redirect to 'cart' route with cart content
       return redirect()->route('cart');
         }
   }


   public function index(){
      $allCartContent = Cart::content();
      return view('frontend.cart', compact('allCartContent'));
     }
  
}