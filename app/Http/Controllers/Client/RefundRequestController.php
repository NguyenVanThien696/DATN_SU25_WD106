<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RefundRequest;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class RefundRequestController extends Controller
{
    public function create($orderId)
    {
        $order = Order::with('orderItems.productVariant.product')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.wallet.form', compact('order'));
    }

public function store(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'reason' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'original_bank_name' => 'required|string|max:255',
        'original_account_number' => 'required|string|max:255',
        'original_account_name' => 'required|string|max:255',
    ]);

    $user = Auth::user();

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('refunds', 'public');
    }

    RefundRequest::create([
        'user_id' => $user->id,
        'order_id' => $request->order_id,
        'reason' => $request->reason,
        'image' => $imagePath,
        'original_bank_name' => $request->original_bank_name,
        'original_account_number' => $request->original_account_number,
        'original_account_name' => $request->original_account_name,
        'status' => 'pending',
    ]);

    return redirect()->route('client.order.index')->with('success', 'Yêu cầu hoàn hàng đã được gửi.');
}




}
