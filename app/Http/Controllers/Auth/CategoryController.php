<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\categories;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.category.add_categories');
    }

    public function store(Request $request){
        //dd($request);
        $credentials = $request->validate([
            'name' => 'required|string',
            'image' => 'required',
        ]);

        $validation = Validator::make($request->all(), [
            'name'=> 'required | string',
            'img'=> 'required',
       ]);
        if($credentials)
        {
            $category= categories::create([
                "name" => $request->name,
                "image" => $request->file('image')->getClientOriginalName(),
                "status" => $request->status??0
            ]);
            
            return redirect()->route('showCategories');
        }
        else{
            return redirect()->route('addCategory')->withInput()->withErrors($credentials);
        }
    }


    public function showCategories(){
        $categories = categories::all();
        
        return view('admin.category.showcategories', compact('categories'));
    }


    public function destroy($id){
        $category= categories::find($id);
        if($category)
        {
            $category->delete();
            return redirect()->route('showCategories');
        }
   
    }


    public function showCategoryPage($id){
        $category = categories::find($id);
        return view('admin.category.edit_categories', compact('category'));
    }

   
    public function editCategory(Request $request){
       //dd($request);
        $categoryId= $request->cid;
        $credentials = $request->validate([
            'name' => 'required|string',
            //'image' => 'required',
        ]);
        
        if($credentials)
        {  
            if($request->file('image'))
            {
                $image= $request->file('image')->getClientOriginalName();
            }
            else{
                $image = categories::find($categoryId)->pluck('image')->first();;
               
            }
           
            $category->update([
                'name' => $request->name,
                'status' => $request->status??0,
            ]);
            return redirect()->route('showCategories');
        }
        else
        {
            return redirect()->route('categories.update', '$categoryId')->withInput()->withErrors($credentials);
        }
      
    }
}
