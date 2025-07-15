<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminVoucherController extends Controller
{
public function index()
{
    // Tự động chuyển sang 'expired' nếu hết hạn
    Coupon::where('status', '!=', 'expired')
        ->whereNotNull('end_at')
        ->where('end_at', '<', now())
        ->update(['status' => 'expired']);

    // Tự động chuyển sang 'used_up' nếu đã dùng đủ số lượt
    Coupon::where('status', '!=', 'used_up')
        ->whereNotNull('usage_limit')
        ->whereColumn('used', '>=', 'usage_limit')
        ->update(['status' => 'used_up']);

    // Tự động chuyển về 'active' nếu còn lượt dùng và chưa hết hạn
    Coupon::where('status', 'used_up')
        ->whereNotNull('usage_limit')
        ->whereColumn('used', '<', 'usage_limit')
        ->where(function ($query) {
            $query->whereNull('end_at')
                ->orWhere('end_at', '>', now());
        })
        ->update(['status' => 'active']);

    $vouchers = Coupon::withCount('users')->latest()->paginate(10);

    return view('admin.vouchers.index', compact('vouchers'));
}


    // Form thêm voucher
    public function create()
    {
        return view('admin.vouchers.create');
    }

    // Xử lý thêm mới voucher
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code|max:50',
            'discount_type' => 'required|in:percent,amount',
            'discount_percent' => 'nullable|numeric|min:1|max:100|required_if:discount_type,percent',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0|required_if:discount_type,amount',
            'usage_limit' => 'nullable|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:active,inactive,expired',
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_percent = $request->discount_type === 'percent' ? $request->discount_percent : null;
        $coupon->discount_amount = $request->discount_type === 'amount' ? $request->discount_amount : null;
        $coupon->max_discount_amount = $request->max_discount_amount;
        $coupon->min_order_amount = $request->min_order_amount;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->used = 0;
        $coupon->start_at = $request->start_at;
        $coupon->end_at = $request->end_at;
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->route('admin.vouchers.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    // Form chỉnh sửa voucher
    public function edit($id)
    {
        $voucher = Coupon::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    // Xử lý cập nhật voucher
    public function update(Request $request, $id)
    {
        $voucher = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|max:50|unique:coupons,code,' . $voucher->id,
            'discount_type' => 'required|in:percent,amount',
            'discount_percent' => 'nullable|numeric|min:1|max:100|required_if:discount_type,percent',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0|required_if:discount_type,amount',
            'usage_limit' => 'nullable|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:active,inactive,expired',
        ]);

        $voucher->code = $request->code;
        $voucher->discount_type = $request->discount_type;
        $voucher->discount_percent = $request->discount_type === 'percent' ? $request->discount_percent : null;
        $voucher->discount_amount = $request->discount_type === 'amount' ? $request->discount_amount : null;
        $voucher->max_discount_amount = $request->max_discount_amount;
        $voucher->min_order_amount = $request->min_order_amount;
        $voucher->usage_limit = $request->usage_limit;
        $voucher->start_at = $request->start_at;
        $voucher->end_at = $request->end_at;
        $voucher->status = $request->status;
        $voucher->save();

        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    // Xóa voucher
    public function destroy($id)
    {
        $voucher = Coupon::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
    public function toggleStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:active,inactive,expired'
    ]);

    $voucher = Coupon::findOrFail($id);
    $voucher->status = $request->status;
    $voucher->save();

    return back()->with('success', 'Cập nhật trạng thái thành công!');
}
}