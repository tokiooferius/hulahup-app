<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard - monitoring/supervision only
     */
    public function dashboard()
    {
        // Get all statistics for dashboard (MONITORING ONLY - READ-ONLY)
        $totalOrders = Order::count();
        $activeUsers = User::where('role', '!=', 'admin')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        // Get recent orders across all canteens
        $recentOrders = Order::with(['user', 'canteen'])
            ->latest()
            ->take(10)
            ->get();
        
        // Get canteen statistics
        $canteenStats = \App\Models\Canteen::with('ibuKantin')
            ->withCount('orders', 'menus', 'vouchers')
            ->get();

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'activeUsers' => $activeUsers,
            'pendingOrders' => $pendingOrders,
            'processingOrders' => $processingOrders,
            'completedOrders' => $completedOrders,
            'recentOrders' => $recentOrders,
            'canteenStats' => $canteenStats,
        ]);
    }

    /**
     * Show all orders across all canteens - for admin monitoring
     */
    public function ordersIndex(Request $request)
    {
        $query = Order::with(['user', 'canteen'])->latest();
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by canteen if provided
        if ($request->has('canteen_id') && $request->canteen_id !== 'all') {
            $query->where('canteen_id', $request->canteen_id);
        }
        
        $orders = $query->paginate(20);
        $canteens = \App\Models\Canteen::all();
        
        return view('admin.orders.index', [
            'orders' => $orders,
            'canteens' => $canteens,
            'currentStatus' => $request->status ?? 'all',
            'currentCanteen' => $request->canteen_id ?? 'all',
        ]);
    }

    /**
     * Show all canteens with management interface
     */
    public function canteensIndex()
    {
        $canteens = \App\Models\Canteen::with('ibuKantin')
            ->withCount(['orders', 'menus', 'vouchers'])
            ->get();
        
        return view('admin.canteens.index', [
            'canteens' => $canteens,
        ]);
    }
}
