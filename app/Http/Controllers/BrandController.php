<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::paginate(10);
        return response()->json($brand, 200);
    }

    public function show($id){
        $brand = Brand::find($id);
        if($brand){
            return response()->json($brand, 200);
        }else{
            return response()->json("Brand not found");
        }
    }
}
