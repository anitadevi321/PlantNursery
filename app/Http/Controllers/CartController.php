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
      $qty = $request->qty ?? 1;
      $product= product::find($request->product_id);

     $productAllreadyExist= false;
      if(Cart::count() > 0)
      {
         $sessionId = Session::getId();
         $cartcontent= cart::content();
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

   // show cart page
   public function index(){
      $allCartContent = Cart::content();
      $total= cart::count();
      return view('frontend.cart', compact('allCartContent'));
     }
}