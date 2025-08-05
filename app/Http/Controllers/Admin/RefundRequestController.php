<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RefundRequest;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RefundRequestController extends Controller
{
public function index(Request $request)
{
    $query = RefundRequest::with('user', 'order')->orderByDesc('created_at');

    if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
        $query->where('status', $request->status);
    }

    $refundRequests = $query->paginate(20)->withQueryString();

    return view('admin.wallet.refund_requests', compact('refundRequests'));
}


    public function show($id)
    {
        $refundRequest = RefundRequest::with('user')->findOrFail($id);

        return view('admin.wallet.refund-requests-show', compact('refundRequest'));
    }

public function update(Request $request, $id)
{
    $refundRequest = RefundRequest::with(['user', 'order'])->findOrFail($id);

    if ($refundRequest->status !== 'pending') {
        return back()->with('error', 'Yêu cầu đã được xử lý.');
    }

    $status = $request->input('status');

    if ($status === 'approved') {
        $request->validate([
            'admin_password' => 'required|string',
        ]);

        $admin = Auth::user();
        if (!Hash::check($request->admin_password, $admin->password)) {
            return back()->with('error', 'Mật khẩu không chính xác.');
        }

        $adminWallet = Wallet::firstOrCreate(['user_id' => $admin->id]);
        $userWallet = Wallet::firstOrCreate(['user_id' => $refundRequest->user_id]);

        $amount = $refundRequest->order->total_price;

        if ($adminWallet->balance < $amount) {
            return back()->with('error', 'Ví admin không đủ để hoàn tiền.');
        }

        DB::beginTransaction();
        try {
            // Trừ ví admin
            $adminWallet->decrement('balance', $amount);
            WalletTransaction::create([
                'wallet_id' => $adminWallet->id,
                'user_id' => $admin->id,
                'amount' => -$amount,
                'type' => 'refund_out',
                'description' => 'Trừ tiền hoàn đơn #' . $refundRequest->order->order_code,
            ]);

            // Cộng ví user
            $userWallet->increment('balance', $amount);
            WalletTransaction::create([
                'wallet_id' => $userWallet->id,
                'user_id' => $refundRequest->user_id,
                'amount' => $amount,
                'type' => 'refund_in',
                'description' => 'Hoàn tiền đơn hàng #' . $refundRequest->order->order_code,
            ]);

            $refundRequest->status = 'approved';
            $refundRequest->save();

            DB::commit();

            return redirect()->route('admin.wallet.refund-requests.index')->with('success', 'Duyệt hoàn tiền thành công.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Lỗi khi hoàn tiền: ' . $e->getMessage());
        }
    }

    if ($status === 'rejected') {
        $refundRequest->status = 'rejected';
        $refundRequest->save();

        return redirect()->route('admin.wallet.refund-requests.index')->with('success', 'Đã từ chối yêu cầu hoàn tiền.');
    }

    return back()->with('error', 'Hành động không hợp lệ.');
}


}
