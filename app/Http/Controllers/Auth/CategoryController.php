<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
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
        try{
            if($credentials)
            {
                if($request->file('image') != '')
                {
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move(public_path('upload_images/category'), $imageName);
                }
    
                $category= categories::create([
                    "name" => $request->name,
                    "image" => $imageName,
                    "status" => $request->status??0
                ]);
                return redirect()->route('showCategories');
            }
            else{
                return redirect()->back()->withInput()->withErrors($credentials);
            }
        }catch(\Exception $e){
            Log::error('Error adding category: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to add category. Please try again.']);
        }
      
    }


    // show all categories
    public function showCategories(){
        $categories = categories::all();
        
        return view('admin.category.showcategories', compact('categories'));
    }


    //show edit category page
    public function showCategoryPage($id){
        try{
            $category = categories::find($id);
            return view('admin.category.edit_categories', compact('category'));
        }catch (\Exception $e) {
            Log::error('Error fetching category: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to find the category. Please try again.']);
        }
     
    }
   
    // edit categories
    public function editCategory(Request $request){
        $categoryId= $request->cid;
       
        $credentials = $request->validate([
            'name' => 'required|string',
        ]);
        $category = categories::find($categoryId); 
        if($credentials)
        {  
            if($request->hasFile('image'))
            {
                $oldpath= public_path('upload_images/category/' . $category->image);
                if (File::exists($oldpath)) {
                    File::delete($oldpath);
                    $imageName = time().'.'.$request->image->extension();
                   $request->image->move(public_path('upload_images/category'), $imageName);
                } 
            }
            else{
                $imageName = $category->image;
            }
            $category->update([
                'name' => $request->name,
                'image' => $imageName,
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
        try{
            $category= categories::find($id);
            if($category)
            {
                $category->delete();
                return redirect()->route('showCategories');
            }
        }catch (\Exception $e) {
            Log::error('Error fetching category: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to find the category. Please try again.']);
        }
       
    }
}