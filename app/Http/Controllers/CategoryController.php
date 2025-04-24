<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\FileException;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::paginate(10);
        return response()->json($category, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json($category, 200);
        } else {
            return response()->json("Category not found");
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:category,name,',
                'image' => 'required'
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return response()->json('Category Added', 201);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function update_Category($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:Category,name,',
                'image' => 'required'
            ]);

            $category = Category::find($id);
            if($request->hasFile('image')){
                $path = 'assets/uploads/category/'. $category->name;
                if(File::exists($path)){
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.'. $ext;

                try{
                    $file->move('assets/uploads/category', $filename);
                }catch(FileException $e){
                    dd($e);
                }
                $category->image = $filename;
            }

           $category->name=$request->name;
           $category->update();
            return response()->json('Category updated', 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function delete_Category($id){
        try {
            $category=Category::where('id',$id);
            if($category){
                $category->delete();
                return response()->json('Category Deleted');
            }
            else{
                return response()->json('Category not found');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
