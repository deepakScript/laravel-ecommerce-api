<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Exception;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::paginate(10);
        return response()->json($brand, 200);
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return response()->json($brand, 200);
        } else {
            return response()->json("Brand not found");
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brand,name,'
            ]);

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->save();

            return response()->json('brand Added', 201);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function update_brand($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brand,name,'
            ]);

            $brand = Brand::where('id', $id)->update([
                'name' => $request->name
            ]);
            return response()->json('brand updated', 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function delete_brand($id){
        try {
            $brand=Brand::where('id',$id);
            if($brand){
                $brand->delete();
                return response()->json('Brand Deleted');
            }
            else{
                return response()->json('Brand not found');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
