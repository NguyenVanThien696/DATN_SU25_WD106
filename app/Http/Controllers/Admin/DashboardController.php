<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Tổng số đơn hàng
        $totalOrders = Order::count();

        // 2. Đơn hàng hôm nay
        $ordersToday = Order::whereDate('created_at', today())->count();

        // 3. Tỷ lệ hoàn thành đơn hàng (hoàn thành / tổng đơn hàng)
        $completedOrders = Order::where('status', 'completed')->count();
        $completionRate = $totalOrders > 0
            ? round(($completedOrders / $totalOrders) * 100, 2)
            : 0;

        // 4. Doanh thu hôm nay
        $revenueToday = Order::whereDate('created_at', today())
            ->where('status', 'completed') // Chỉ tính doanh thu từ đơn hàng đã hoàn thành
            ->sum('total_price');

        // 5. Doanh thu tháng hiện tại
        $revenueMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('total_price');

        // 6. Tổng khách hàng (role = 2 là khách)
        $totalCustomers = User::where('role', 2)->count();

        // 7. Sản phẩm sắp hết hàng
        $lowStockCount = ProductVariant::where('stock', '<', 5)->count();

        // 8. Tổng sản phẩm
        $totalProducts = Product::count();

        // 9. Tổng mã giảm giá
        $totalCoupons = Coupon::count();

        // 10. Đơn hàng mới nhất
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // 11. Biểu đồ doanh thu 30 ngày
        $revenueLabels = [];
        $revenueData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $label = $date->format('d/m');
            $revenueLabels[] = $label;

            $revenue = Order::whereDate('created_at', $date)
                ->where('status', 'completed') // Chỉ tính đơn hoàn thành
                ->sum('total_price');

            $revenueData[] = $revenue;
        }
        // 12. Tình trạng đơn hàng theo trạng thái
        $orderStatusChart = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 13. Sản phẩm đã bán (tổng số lượng)
        $totalSold = DB::table('order_items')->sum('quantity');

        // 14. Top 5 sản phẩm bán chạy
        $topProducts = DB::table('order_items')
            ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // 16. Top 5 khách hàng mua nhiều nhất (theo tổng tiền đơn hàng đã hoàn thành)
        $topCustomers = Order::where('status', 'completed')
            ->select('user_id', DB::raw('SUM(total_price) as total_spent'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->take(5)
            ->with('user') // eager load để tránh N+1 query
            ->get()
            ->filter(fn($order) => $order->user); // lọc những đơn không có user (phòng trường hợp bị xóa)

        // 15. Truyền ra view
        return view('admin.admin-home', compact(
            'totalOrders',
            'ordersToday',
            'completionRate',
            'revenueToday',
            'revenueMonth',
            'totalCustomers',
            'lowStockCount',
            'totalProducts',
            'totalCoupons',
            'recentOrders',
            'revenueLabels',
            'revenueData',
            'orderStatusChart',
            'topProducts',
            'totalSold',
            'topCustomers',
        ));
    }
}
