<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        if ($products) {
            return response()->json($products, 200);
        } else
            return response()->json('No Products');
    }


    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product, 200);
        } else
            return response()->json('Product was not found');
    }


    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'image' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->discount = $request->discount;
        $product->amount = $request->amount;

        if ($request->hasFile('image')) {
            $path = 'assets/uploads/product/' . $product->name;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;

            try {
                $file->move('assets/uploads/product', $filename);
            } catch (FileException $e) {
                dd($e);
            }
            $product->image = $filename;
        }

        $product->save();
        return response()->json('Product Added', 201);

    }


    public function update($id, Request $request)
    {
        $request = Product::find($id);
        Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'image' => 'required'
        ]);
        $product = new Product();

        if ($product) {


            $product->name = $request->name;
            $product->price = $request->price;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->discount = $request->discount;
            $product->amount = $request->amount;


            if ($request->hasFile('image')) {
                $path = 'assets/uploads/product/' . $product->name;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;

                try {
                    $file->move('assets/uploads/product', $filename);
                } catch (FileException $e) {
                    dd($e);
                }
                $product->image = $filename;
            }

            $product->save();
            return response()->json('Proudct Updated');
        } else
            return response()->json('Product Not found');
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json('Product deleted');
        } else
            return response()->json('Product not found');
    }
}
