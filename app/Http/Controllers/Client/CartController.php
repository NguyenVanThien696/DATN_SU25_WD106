<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        
    if(Auth::check()) {
        $cart = Cart::where('user_id', Auth::id())
        
            ->with('items.variant.product', 'items.variant.size', 'items.variant.color')
            ->first();

        return view('client.cart.index', compact('cart'));
    } else {
        $cart = session()->get('cart', []);
        return view('client.cart.index', compact('cart'));
    }
    
}



public function add(Request $request){
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'size_id'    => 'required|exists:sizes,id',
        'color_id'   => 'required|exists:colors,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $variant = ProductVariant::where([
        'product_id' => $request->product_id,
        'size_id'    => $request->size_id,
        'color_id'   => $request->color_id,
    ])->first();

    if (!$variant) {
        return back()->with('error', 'Không tìm thấy biến thể sản phẩm');
    }

    $requestedQty = $request->quantity;

    if (Auth::check()) {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_variant_id', $variant->id)
                        ->first();

        $currentQtyInCart = $item ? $item->quantity : 0;

        if (($currentQtyInCart + $requestedQty) > $variant->stock) {
            return back()->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
        }

        if ($item) {
            $item->quantity += $requestedQty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id'            => $cart->id,
                'product_variant_id' => $variant->id,
                'quantity'           => $requestedQty
            ]);
        }
    } else {
        $cart = session()->get('cart', []);
        $key = $variant->id;
        $currentQtyInCart = isset($cart[$key]) ? $cart[$key]['quantity'] : 0;

        if (($currentQtyInCart + $requestedQty) > $variant->stock) {
            return back()->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $requestedQty;
        } else {
            $cart[$key] = [
                'variant_id' => $variant->id,
                'product_id' => $request->product_id,
                'size_id'    => $request->size_id,
                'color_id'   => $request->color_id,
                'quantity'   => $requestedQty
            ];
        }

        session()->put('cart', $cart);
    }

    return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
}

    public function update(Request $request){

    $quantities = $request->input('quantity', []);
     if (Auth::check()) {
        $cart = Cart::where('user_id', Auth::id())->with('items.variant.product')->first();
        if($cart){
            foreach($quantities as $variantId => $qty){
                $variant = ProductVariant::with('product')->find($variantId);
                if($qty > $variant->stock){
                    return back()->with('error', 'Số lượng vượt quá tồn kho cho sản phẩm: ' . $variant->product->name);
                }
                CartItem::where('cart_id', $cart->id)->where('product_variant_id', $variantId)->update(['quantity' => max(1, (int)$qty)]);
            }
        }else{
            $cart = session()->get('cart', []);
            foreach($quantities as $variantId => $qty){
                if(isset($cart[$variantId])){
                    $cart[$variantId]['quantity'] = max(1, (int)$qty);
                }
            }
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Cập nhật giỏ hàng thành công!');

        $products = $cart->items;

    }
}
    public function delete($variantId)
{
    if (Auth::check()) {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();

        if ($cart) {
            CartItem::where('cart_id', $cart->id)
                    ->where('product_variant_id', $variantId)
                    ->delete();
        }
    } else {
        $cart = session()->get('cart', []);
        foreach ($cart as $key => $item) {
            if ($item['variant_id'] == $variantId) {
                unset($cart[$key]);
            }
        }
        session()->put('cart', $cart);
    }

    return redirect()->route('client.cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
}

}