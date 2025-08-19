<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletTransactionController extends Controller
{
public function index()
{
    $admin = User::where('role', 1)->with('wallet')->first();

    if ($admin && !$admin->wallet) {
        $admin->wallet()->create(['balance' => 0]);
    }

    $admin->load('wallet');

    $users = User::where('role', '!=', 1) 
        ->with([
            'wallet',
            'walletTransactions' => fn($q) => $q->latest()->take(5)
        ])
        ->has('wallet') 
        ->get();

    return view('admin.wallet.index', compact('admin', 'users'));
}



public function show($id)
{
    $user = User::with([
        'wallet',
        'walletTransactions' => fn($q) => $q->latest()
    ])->findOrFail($id);

    return view('admin.wallet.show', compact('user'));
}

    public function adminDepositForm()
{
    $admin = Auth::user();
    return view('admin.wallet.deposit_admin', compact('admin'));
}


public function adminDepositRedirect(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1000',
        'description' => 'nullable|string|max:255',
    ], [
        'amount.required' => 'Số tiền là bắt buộc.',
        'amount.numeric'  => 'Số tiền phải là một số.',
        'amount.min'      => 'Số tiền tối thiểu là :min đồng.',

        'description.string' => 'Mô tả phải là chuỗi ký tự.',
        'description.max'    => 'Mô tả không được vượt quá :max ký tự.',
    ]);

    $admin = User::where('role', 1)->first();
    if (!$admin || !$admin->wallet) {
        return back()->with('error', 'Không tìm thấy ví của admin.');
    }

    $currentBalance = $admin->wallet->balance;
    $amountToAdd = $request->amount;

    if ($currentBalance >= 25000000) {
        return back()->with('error', 'Số dư ví đã đạt tối đa 25,000,000 VNĐ. Không thể nạp thêm.');
    }

    if (($currentBalance + $amountToAdd) > 25000000) {
        return back()->with('error', 'Số tiền nạp sẽ khiến số dư vượt quá giới hạn 25,000,000 VNĐ.');
    }

    // VNPay xử lý
    $txnRef = uniqid('ADMIN_');
    $vnp_Url = config('services.vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
    $vnp_Returnurl = route('admin.wallet.deposit.admin.callback');
    $vnp_TmnCode = env('VNPAY_TMN_CODE');
    $vnp_HashSecret = env('VNPAY_HASH_SECRET');
    $vnp_OrderInfo = $request->description ?? 'Nạp ví admin';
    $vnp_OrderType = 'topup';
    $vnp_Amount = $amountToAdd * 100; // VNPay x100
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $request->ip();

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $txnRef,
    ];

    if (!empty($vnp_BankCode)) {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        $hashdata .= ($i ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
        $i++;
    }

    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

    // Lưu session để xử lý callback
    session([
        'admin_deposit_txn_ref' => $txnRef,
        'admin_deposit_amount' => $amountToAdd,
    ]);

    return redirect($vnp_Url);
}


public function adminDepositCallback(Request $request)
{
    $inputData = $request->all();

    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
    unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

    ksort($inputData);
    ksort($inputData);
    $hashData = '';
    $i = 0;
    foreach ($inputData as $key => $value) {
        $hashData .= ($i ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        $i++;
    }
    $secureHash = hash_hmac('sha512', $hashData, env('VNPAY_HASH_SECRET'));

    if ($secureHash !== $vnp_SecureHash) {
        return redirect()->route('admin.wallet.transactions.index')->with('error', 'Giao dịch thất bại hoặc sai chữ ký.');
    }

    if (
        $request->vnp_ResponseCode !== '00' ||
        $request->vnp_TransactionStatus !== '00'
    ) {
        return redirect()->route('admin.wallet.transactions.index')->with('error', 'Giao dịch không thành công.');
    }

    $txnRef = $request->vnp_TxnRef;

    if (!str_starts_with($txnRef, 'ADMIN_')) {
        return redirect()->route('admin.wallet.transactions.index')->with('error', 'Mã giao dịch không hợp lệ.');
    }

$admin = User::where('role', 1)->first();
if (!$admin || !$admin->wallet) {
    return redirect()->route('admin.wallet.transactions.index')->with('error', 'Ví admin không tồn tại.');
}
$wallet = $admin->wallet;

    if (WalletTransaction::where('description', 'like', "%$txnRef%")->exists()) {
        return redirect()->route('admin.wallet.transactions.index')->with('error', 'Giao dịch này đã được xử lý trước đó.');
    }

    $amount = $request->vnp_Amount / 100;
    if (($wallet->balance + $amount) > 25000000) {
        return redirect()->route('admin.wallet.transactions.index')->with('error', 'Số dư ví không được vượt quá 25 triệu.');
    }

    $wallet->increment('balance', $amount);

    WalletTransaction::create([
        'wallet_id'   => $wallet->id,
        'user_id'     => $admin->id,
        'type'        => 'deposit',
        'amount'      => $amount,
        'description' => 'Nạp ví admin - Mã giao dịch: ' . $txnRef,
    ]);

    return redirect()->route('admin.wallet.transactions.index')->with('success', 'Nạp ví thành công.');
}



}