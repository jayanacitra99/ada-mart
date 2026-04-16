<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllNotification;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    public function index(){
        $data = [
            'orders'    => Order::all()->count(),
            'categories'=> Categories::all()->count(),
            'promos'    => Promo::all()->count(),
            'products'  => Product::all()->count(),
        ];
        return view('Admin.dashboard', $data);
    }

    public function monthlyOrders()
    {
        $monthlyOrders = Order::selectRaw('DATE_FORMAT(completed_at, "%Y-%m") as month, COUNT(*) as total_orders, SUM(total) as total_amount')
                                ->where('status', Order::COMPLETED)
                                ->groupBy('month')
                                ->orderBy('month')
                                ->get();

        $months = [];
        $orders = [];
        $totals = [];

        // Initialize array with zeros for each month
        $startMonth = Carbon::now()->subMonths(6); // Change 6 to the number of months you want to display
        $endMonth = Carbon::now();
        $interval = $startMonth->diffInMonths($endMonth);
        for ($i = 0; $i <= $interval; $i++) {
            $month = $startMonth->copy()->addMonths($i);
            $months[] = $month->format('Y-m');
            $orders[$month->format('Y-m')] = 0;
            $totals[$month->format('Y-m')] = 0.00;
        }

        // Fill the actual orders count and total amounts
        foreach ($monthlyOrders as $monthlyOrder) {
            $orders[$monthlyOrder->month] = $monthlyOrder->total_orders;
            $totals[$monthlyOrder->month] = 'Rp '.\number_format($monthlyOrder->total_amount,0,',','.');
        }

        return response()->json([
            'months' => $months,
            'orders' => array_values($orders), // Return only values without keys
            'totals' => array_values($totals) // Return only values without keys
        ]);
    }


    public function markAsRead(Request $request)
    {
        $notif = AllNotification::find($request->notifID);
        AllNotification::destroy($request->notifID);
        if($notif->name == 'low_stock'){
            return view('Admin.low_stock_notification');
        } else if($notif->name == 'new_order') {
            return view('Admin.new_order_notification');
        }
    }
}
