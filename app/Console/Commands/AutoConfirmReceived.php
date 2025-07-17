<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class AutoConfirmReceived extends Command
{
    protected $signature = 'orders:auto-confirm';

    protected $description = 'Tự động xác nhận đơn hàng sau 3 ngày nếu khách chưa xác nhận.';

    public function handle(): int
    {
        $orders = Order::where('status', 'delivered')
            ->where('updated_at', '<=', Carbon::now()->subDays(3))
            ->get();

        foreach ($orders as $order) {
            $order->status = 'completed';

            if ($order->payment_status !== 'paid') {
                $order->payment_status = 'paid';
            }

            $order->save();

            $this->info("Đã tự xác nhận đơn hàng ID: {$order->id}");
        }

        return self::SUCCESS;
    }
}
