<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        // đảm bảo có dữ liệu mới nhất + load quan hệ
        $this->order = $order->fresh()->loadMissing([
            'orderItems.productVariant.product',
            'shippingAddress',
        ]);
    }

    public function build()
    {
        $code = $this->order->order_code ?: $this->order->id;

        return $this->subject('Xác nhận đơn hàng #' . $code)
            ->view('emails.orders.confirmation')
            ->with('order', $this->order);
    }
}
