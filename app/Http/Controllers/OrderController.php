<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class OrderController extends Controller
{
    public function index(){
        $orders= Order::with('user')->paginate(20);
        Return response()->json($orders,200);
    }
}
