<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use App\Models\Location;
use Exception;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->paginate(20);

        if ($orders) {
            foreach ($orders as $order) {
                foreach ($order->items as $order_items) {
                    $product = Product::where('id', $order_items->product_id)->pluck('name');
                    $order_items->product_name = $product['0'];
                }
            }
            return response()->json($orders, 200);
        } else
            return response()->json('There is no orders');

    }

    public function show($id)
    {
        $order = Order::find($id);
        return response()->json($order, 200);
    }


    public function store(Request $request)
    {
        try {
            $location = Location::where('user_id', Auth::id())->first();

            $request->validate([
                'order_items' => 'required',
                'total_price' => 'required',
                'quantity' => 'required',
                'date_of_delivery' => 'required'
            ]);

            $order = new Order();
            $order->user_id = Auth::id();
            $order->location_id = $location->id;
            $order->total_price = $request->total_price;
            $order->date_of_delivery = $request->date_of_delivery;


            foreach ($request->order_items as $order_items) {
                $items = new OrderItems();
                $items->order_id = $order->id;
                $items->price = $order_items['price'];
                $items->product_id = $order_items['product_id'];
                $items->quantity = $order_items['quantity'];

                $items->save();

                $product = Product::where('id', $order_items['product_id'])->first();

                $product->quantity -= $order_items['quantity'];
                $product->save();
            }

            return response()->json('order is added', 201);
        }catch(Exception $e){
            return response()->json($e);
        }
    }


    public function get_roder_items($id){
        $order_items = OrderItems::where('order_id', $id)->get();
        if($order_items){
            foreach($order_items as $order_item)
            {
                $product = Product::where('id', $order_items->product_id)->pluck('name');
                $order_items->product_name=$product['0'];
            }
            return response()->json($order_items);
        }else return response()->json('no items found ');
    }


    public function get_user_order($id){
        $orders= Order::where('user_id', $id)::with('items', function($query){
            $query->orderBy('created_at','desc');
        })->get();

        if($orders){
            foreach($orders->items as $order){
                $product = Product::where('id', $order->product_id)->pluck('name');
                $order->product_name=$product['0'];
            }
            return response()->json($orders);
        }
        else return response()->json('no order found for this user');
    }



    public function change_order_status($id, Request $request){
        $order= Order::find($id);
        if($order){
            $order->update(['status'=>$request->status]);
            return response()->json('Status Changed Successful');
        }
        else return response()->json('Order was not found');
    }
}
