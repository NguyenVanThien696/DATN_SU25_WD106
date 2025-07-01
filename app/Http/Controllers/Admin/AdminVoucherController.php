<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminVoucherController extends Controller
{
    // Hiển thị danh sách voucher
    public function index()
    {
    $vouchers = \App\Models\Coupon::withCount('users')->latest()->paginate(10);
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
}