<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\categories;

class CategoryController extends Controller
{
    //show add category page
    public function index(){
        return view('admin.category.add_categories');
    }

    // store category
    public function store(Request $request){
        $credentials = $request->validate([
            'name' => 'required|string',
            'image' => 'required',
        ]);

    //     $validation = Validator::make($request->all(), [
    //         'name'=> 'required | string',
    //         'img'=> 'required',
    //    ]);
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


    // show all categories
    public function showCategories(){
        $categories = categories::all();
        
        return view('admin.category.showcategories', compact('categories'));
    }


    //show edit category page
    public function showCategoryPage($id){
        $category = categories::find($id);
        return view('admin.category.edit_categories', compact('category'));
    }

   
    // edit categories
    public function editCategory(Request $request){
        $categoryId= $request->cid;
        $credentials = $request->validate([
            'name' => 'required|string',
            //'image' => 'required',
        ]);
        $category = categories::find($categoryId)->pluck('image')->first();; 
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


    // destroy categories
    public function destroy($id){
        $category= categories::find($id);
        if($category)
        {
            $category->delete();
            return redirect()->route('showCategories');
        }
   
    }
}