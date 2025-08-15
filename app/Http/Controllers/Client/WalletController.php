<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\RefundRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WalletController extends Controller
{
public function index()
{
    $wallet = Wallet::where('user_id', Auth::id())->first();

    $transactions = $wallet 
        ? $wallet->transactions()->orderByDesc('created_at')->get()
        : collect();

    return view('client.wallet.index', compact('wallet', 'transactions'));
}


    public function showDepositForm()
    {
        return view('client.wallet.deposit');
    }

public function DepositRedirect(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1000',
        'description' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();
    if (!$user || !$user->wallet) {
        return back()->with('error', 'Không tìm thấy ví.');
    }

    $currentBalance = $user->wallet->balance;
    $amountToAdd = $request->amount;

    if ($currentBalance >= 25000000) {
        return back()->with('error', 'Số dư ví đã đạt tối đa 25,000,000 VNĐ. Không thể nạp thêm.');
    }

    if (($currentBalance + $amountToAdd) > 25000000) {
        return back()->with('error', 'Số tiền nạp sẽ khiến số dư vượt quá giới hạn 25,000,000 VNĐ.');
    }

    // VNPay xử lý
    $txnRef = uniqid('USER_' . $user->id . '_');
    $vnp_Url = config('services.vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
    $vnp_Returnurl = route('client.wallet.deposit.callback');
    $vnp_TmnCode = env('VNPAY_TMN_CODE');
    $vnp_HashSecret = env('VNPAY_HASH_SECRET');
    $vnp_OrderInfo = $request->description ?? 'Nạp ví';
    $vnp_OrderType = 'topup';
    $vnp_Amount = $amountToAdd * 100; // VNPay yêu cầu x100
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $request->ip();

    $inputData = [
        "vnp_Version"   => "2.1.0",
        "vnp_TmnCode"   => $vnp_TmnCode,
        "vnp_Amount"    => $vnp_Amount,
        "vnp_Command"   => "pay",
        "vnp_CreateDate"=> date('YmdHis'),
        "vnp_CurrCode"  => "VND",
        "vnp_IpAddr"    => $vnp_IpAddr,
        "vnp_Locale"    => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef"    => $txnRef,
    ];

    if (!empty($vnp_BankCode)) {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $hashdata = '';
    $query = '';
    $i = 0;
    foreach ($inputData as $key => $value) {
        $hashdata .= ($i ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        $query    .= urlencode($key) . "=" . urlencode($value) . '&';
        $i++;
    }

    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

    session([
        'deposit_txn_ref' => $txnRef,
        'deposit_amount'  => $amountToAdd,
    ]);

    return redirect($vnp_Url);
}

public function DepositCallback(Request $request)
{
    $inputData = $request->all();
    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;

    unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

    ksort($inputData);

    $hashData = '';
    $i = 0;
    foreach ($inputData as $key => $value) {
        $hashData .= ($i ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        $i++;
    }

    $secureHash = hash_hmac('sha512', $hashData, env('VNPAY_HASH_SECRET'));

    if ($secureHash !== $vnp_SecureHash) {
        return redirect()->route('client.wallet.index')->with('error', 'Giao dịch thất bại hoặc sai chữ ký.');
    }

    if (
        $request->vnp_ResponseCode !== '00' ||
        $request->vnp_TransactionStatus !== '00'
    ) {
        return redirect()->route('client.wallet.index')->with('error', 'Giao dịch không thành công.');
    }

    $txnRef = $request->vnp_TxnRef;

    if (!str_starts_with($txnRef, 'USER_')) {
        return redirect()->route('client.wallet.index')->with('error', 'Mã giao dịch không hợp lệ.');
    }

    $parts = explode('_', $txnRef);
    if (count($parts) < 2 || !is_numeric($parts[1])) {
        return redirect()->route('client.wallet.index')->with('error', 'Không xác định được người dùng.');
    }
    $userId = (int)$parts[1];

    $user = User::find($userId);
    if (!$user || !$user->wallet) {
        return redirect()->route('client.wallet.index')->with('error', 'Ví không tồn tại.');
    }
    $wallet = $user->wallet;

    if (WalletTransaction::where('description', 'like', "%$txnRef%")->exists()) {
        return redirect()->route('client.wallet.index')->with('error', 'Giao dịch này đã được xử lý trước đó.');
    }

    $amount = $request->vnp_Amount / 100;
    if (($wallet->balance + $amount) > 25000000) {
        return redirect()->route('client.wallet.index')->with('error', 'Số dư ví không được vượt quá 25 triệu.');
    }

    $wallet->increment('balance', $amount);

    WalletTransaction::create([
        'wallet_id'   => $wallet->id,
        'user_id'     => $user->id,
        'type'        => 'deposit',
        'amount'      => $amount,
        'description' => 'Nạp ví người dùng - Mã giao dịch: ' . $txnRef,
    ]);

    return redirect()->route('client.wallet.index')->with('success', 'Nạp tiền vào ví thành công.');
}

    public function showWithdrawForm()
    {
        $user = Auth::user();

        if (!$user || !$user->wallet) {
            return redirect()->route('client.wallet.index')
                ->with('error', 'Không tìm thấy ví của bạn.');
        }

        $bankInfo = $user->bankAccount; 

        return view('client.wallet.withdraw', [
            'wallet'     => $user->wallet,
            'bank_info'  => $bankInfo
        ]);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:10000',
            'account_number' => 'required|string|max:255',
            'bank_name'      => 'required|string|max:255',
            'account_name'   => 'required|string|max:255',
            'password'       => 'required|string',
            'description'    => 'nullable|string|max:255',
        ], [
            'amount.required'         => 'Vui lòng nhập số tiền cần rút.',
            'amount.numeric'          => 'Số tiền phải là số.',
            'amount.min'              => 'Số tiền tối thiểu để rút là 10.000 VNĐ.',

            'account_number.required' => 'Vui lòng nhập số tài khoản.',
            'account_number.string'   => 'Số tài khoản không hợp lệ.',
            'account_number.max'      => 'Số tài khoản tối đa 255 ký tự.',

            'bank_name.required'      => 'Vui lòng nhập tên ngân hàng.',
            'bank_name.string'        => 'Tên ngân hàng không hợp lệ.',
            'bank_name.max'           => 'Tên ngân hàng tối đa 255 ký tự.',

            'account_name.required'   => 'Vui lòng nhập tên chủ tài khoản.',
            'account_name.string'     => 'Tên chủ tài khoản không hợp lệ.',
            'account_name.max'        => 'Tên chủ tài khoản tối đa 255 ký tự.',

            'password.required'       => 'Vui lòng nhập mật khẩu để xác nhận.',
            'password.string'         => 'Mật khẩu không hợp lệ.',

            'description.string'      => 'Ghi chú không hợp lệ.',
            'description.max'         => 'Ghi chú tối đa 255 ký tự.',
        ]);


        $user = Auth::user();

        if (!$user || !$user->wallet) {
            return redirect()->route('client.wallet.index')
                ->with('error', 'Không tìm thấy ví.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Mật khẩu không đúng.');
        }

        $wallet = $user->wallet;
        $amount = $request->amount;

        if ($amount > $wallet->balance) {
            return back()->with('error', 'Số dư ví không đủ để rút.');
        }

        // Trừ tiền ví
        $wallet->decrement('balance', $amount);

        // Lưu lịch sử giao dịch
        WalletTransaction::create([
            'wallet_id'   => $wallet->id,
            'user_id'     => $user->id,
            'type'        => 'withdraw',
            'amount'      => $amount,
            'description' => $request->description ?? 'Rút tiền từ ví',
        ]);

        // Lưu / cập nhật thông tin ngân hàng
        $bankAccount = $user->bankAccount;
        $bankData = $request->only(['account_number', 'bank_name', 'account_name']);

        if ($bankAccount) {
            $bankAccount->update($bankData);
        } else {
            $user->bankAccount()->create($bankData);
        }

        return redirect()->route('client.wallet.index')
            ->with('success', 'Rút tiền thành công.');
    }

}