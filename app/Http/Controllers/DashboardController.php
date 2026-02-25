<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's orders
        $orders = Order::where('user_id', $user->id)
            ->with(['branch'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get order counts
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
            
        // Get total spent
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->where('payment_status', 'paid')
            ->sum('total');

        return view('dashboard', compact(
            'user', 
            'orders', 
            'pendingOrders', 
            'completedOrders',
            'totalSpent'
        ));
    }
}
