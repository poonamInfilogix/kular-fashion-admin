<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count(); 
        $orderCount = Order::count();
        $productCount = Product::count();
        $latestOrder = Order::latest()->first();

        return view ('dashboard.index', compact('userCount', 'orderCount', 'productCount', 'latestOrder'));
    }
}
