<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        $userId = Auth::id();
        $productId = $request->product_id;
        $orderItemId = $request->order_item_id;
        // Kiểm tra oder item có hợp lệ  và thuoc về người dùng nào
        $orderItem = OrderItem::with('order', 'productVariant')->where('id', $orderItemId)->first();

        if (
            !$orderItem ||
            $orderItem->order->user_id !== $userId ||
            $orderItem->order->status !== 'completed'
        ) {
            return back()->with('error', 'Đơn hàng không hợp lệ để đánh giá.');
        }

        if ($orderItem->productVariant->product_id != $productId) {
            return back()->with('error', 'Sản phẩm không khớp với đơn hàng.');
        }

        // Kiểm tra đã đánh giá sản phẩm này trong đơn hàng này chưa
        $alreadyReviewed = ProductReview::where('product_id', $productId)
            ->where('user_id', $userId)
            ->whereHas('orderItem', function ($query) use ($orderItem) {
                $query->where('order_id', $orderItem->order_id);
            })
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này trong đơn hàng này.');
        }

        ProductReview::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'order_item_id' => $orderItemId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}