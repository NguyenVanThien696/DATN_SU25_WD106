<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        // dd(session('cart'));
        $cart = session()->get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    public function add(Request $request){
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $product = \App\Models\Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if(isset($cart[$productId])){
            $cart[$productId]['quantity'] += $quantity;
        }else{
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'options' => [
                    'image' => $product->image,
                ],
                
                'quantity' => $quantity
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('client.cart.index')->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request){

        $quantities = $request->quantity; // Mảng quantity[id] => số lượng
    $cart = session()->get('cart', []);

    foreach ($quantities as $id => $qty) {
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$qty); // Không cho nhỏ hơn 1
        }
    }

    session()->put('cart', $cart);

    return back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    public function delete($id){

        $cart = session()->get('cart');

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('client.cart.index');
    }

    public function clear(){
        session()->forget('cart');
        return redirect()->back()->with('success', 'đã xóa giỏ hàng');
    }
}
