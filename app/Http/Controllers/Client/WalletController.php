<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

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

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $wallet = Wallet::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0]
        );

        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect()->route('wallet.index')->with('success', 'Nạp tiền thành công!');
    }

    public function showWithdrawForm()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('client.wallet.withdraw', compact('wallet'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $wallet = Wallet::where('user_id', Auth::id())->first();

        if (!$wallet || $wallet->balance < $request->amount) {
            return redirect()->back()->with('error', 'Số dư không đủ để rút.');
        }

        $wallet->balance -= $request->amount;
        $wallet->save();

        return redirect()->route('wallet.index')->with('success', 'Rút tiền thành công!');
    }
}
