<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng #{{ $order->order_code ?? $order->id }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">

    <div
        style="max-width: 700px; margin: auto; background: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">

        <!-- Header -->
        <div style="background-color: #4CAF50; padding: 20px; color: white; text-align: center;">
            <h2 style="margin: 0;">Xác nhận đơn hàng</h2>
        </div>

        <!-- Nội dung chính -->
        <div style="padding: 20px; color: #333;">
            <p>Xin chào <strong>{{ $order->user->name ?? 'Quý khách' }}</strong>,</p>
            <p>Cảm ơn bạn đã mua sắm tại <strong>ModaVie</strong>. Đơn hàng của bạn đã được ghi nhận
                thành công.</p>

            <!-- Thông tin đơn hàng -->
            <table width="100%" cellpadding="8" cellspacing="0" style="margin-bottom: 20px; font-size: 14px;">
                <tr>
                    <td><strong>Mã đơn hàng:</strong></td>
                    <td>#{{ $order->order_code ?? $order->id }}</td>
                </tr>
                <tr>
                    <td><strong>Ngày đặt:</strong></td>
                    <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Phương thức thanh toán:</strong></td>
                    <td>{{ strtoupper($order->payment_method) }}</td>
                </tr>
                <tr>
                    <td><strong>Trạng thái thanh toán:</strong></td>
                    <td>{{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                </tr>
            </table>

            <!-- Chi tiết sản phẩm -->
            <h3 style="margin-top: 0; margin-bottom: 10px; color: #4CAF50;">Chi tiết sản phẩm</h3>
            <table width="100%" cellpadding="10" cellspacing="0" border="1"
                style="border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th align="left">Sản phẩm</th>
                        <th align="center">Số lượng</th>
                        <th align="right">Đơn giá</th>
                        <th align="right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->productVariant->product->name ?? 'Sản phẩm' }}</td>
                            <td align="center">{{ $item->quantity }}</td>
                            <td align="right">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            <td align="right">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tổng kết -->
            <table width="100%" cellpadding="8" cellspacing="0" style="margin-top: 15px; font-size: 14px;">
                @if($order->discount > 0)
                    <tr>
                        <td align="right"><strong>Giảm giá:</strong></td>
                        <td align="right" style="color: red;">-{{ number_format($order->discount, 0, ',', '.') }} đ</td>
                    </tr>
                @endif
                @if($order->shipping_fee > 0)
                    <tr>
                        <td align="right"><strong>Phí vận chuyển:</strong></td>
                        <td align="right">{{ number_format($order->shipping_fee, 0, ',', '.') }} đ</td>
                    </tr>
                @endif
                <tr style="font-size: 16px; background-color: #f2f2f2;">
                    <td align="right"><strong>Tổng thanh toán:</strong></td>
                    <td align="right" style="color: #4CAF50;">
                        <strong>{{ number_format($order->total_price, 0, ',', '.') }} đ</strong>
                    </td>
                </tr>
            </table>

            <p style="margin-top: 20px;">Chúng tôi sẽ liên hệ với bạn để xác nhận và giao hàng sớm nhất.</p>
            <p>Trân trọng cảm ơn,<br><strong><strong>ModaVie</strong></p>
        </div>
    </div>
</body>

</html>