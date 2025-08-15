<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->with('items.variant.product', 'items.variant.size', 'items.variant.color')
                ->first();

            return view('client.cart.index', [
                'cart' => $cart,
                'sessionCart' => null
            ]);
        } else {
            $sessionCart = session()->get('cart', []);
            return view('client.cart.index', [
                'cart' => null,
                'sessionCart' => $sessionCart
            ]);
        }
    }
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id'    => 'required|exists:sizes,id',
            'color_id'   => 'required|exists:colors,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $sizeId    = $request->size_id;
        $colorId   = $request->color_id;
        $quantity  = $request->quantity;

        $variant = ProductVariant::where([
            'product_id' => $productId,
            'size_id'    => $sizeId,
            'color_id'   => $colorId,
        ])->first();
        if (!$variant) {
            Log::warning(' Không tìm thấy biến thể', [
                'product_id' => $productId,
                'size_id'    => $sizeId,
                'color_id'   => $colorId,
            ]);
            return back()->with('error', 'Không tìm thấy biến thể sản phẩm');
        }

        $requestedQty = $quantity;

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            Log::info('Cart đã tạo hoặc tìm thấy', $cart->toArray());

            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $variant->id)
                ->first();

            $currentQtyInCart = $item ? $item->quantity : 0;

            if (($currentQtyInCart + $requestedQty) > $variant->stock) {
                Log::warning('Số lượng vượt quá tồn kho', [
                    'current' => $currentQtyInCart,
                    'add'     => $requestedQty,
                    'stock'   => $variant->stock
                ]);
                return back()->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
            }

            if ($item) {
                $item->quantity += $requestedQty;
                $item->save();
            } else {
                $newItem = CartItem::create([
                    'cart_id'            => $cart->id,
                    'product_variant_id' => $variant->id,
                    'quantity'           => $requestedQty
                ]);
            }
        } else {
            // Giỏ hàng với session (khách chưa đăng nhập)
            $cart = session()->get('cart', []);
            $key = $variant->id;

            $currentQtyInCart = isset($cart[$key]) ? $cart[$key]['quantity'] : 0;

            if (($currentQtyInCart + $requestedQty) > $variant->stock) {
                Log::warning('Số lượng vượt quá tồn kho (session)', [
                    'current' => $currentQtyInCart,
                    'add'     => $requestedQty,
                    'stock'   => $variant->stock
                ]);
                return back()->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
            }

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $requestedQty;
                Log::info('Cập nhật số lượng sản phẩm trong giỏ (session)', [
                    'variant_id'   => $key,
                    'new_quantity' => $cart[$key]['quantity']
                ]);
            } else {
                $cart[$key] = [
                    'variant_id' => $variant->id,
                    'product_id' => $productId,
                    'size_id'    => $sizeId,
                    'color_id'   => $colorId,
                    'quantity'   => $requestedQty
                ];
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }



    public function update(Request $request)
    {

        $quantities = $request->input('quantity', []);
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->with('items.variant.product')->first();
            if ($cart) {
                foreach ($quantities as $variantId => $qty) {
                    $variant = ProductVariant::with('product')->find($variantId);
                    if ($qty > $variant->stock) {
                        return back()->with('error', 'Số lượng vượt quá tồn kho cho sản phẩm: ' . $variant->product->name);
                    }
                    CartItem::where('cart_id', $cart->id)->where('product_variant_id', $variantId)->update(['quantity' => max(1, (int)$qty)]);
                }
            } else {
                $cart = session()->get('cart', []);
                foreach ($quantities as $variantId => $qty) {
                    if (isset($cart[$variantId])) {
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
    public function clear()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)->delete();
            }
        } else {
            session()->forget('cart');
        }

        return redirect()->route('client.cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }

    public function updateQuantity(Request $request)
{
    $cartItemId = $request->input('cart_item_id');
    $quantity = $request->input('quantity');

    $cartItem = CartItem::find($cartItemId);
    if (!$cartItem) {
        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
    }

    $cartItem->quantity = $quantity;
    $cartItem->save();

    return response()->json(['success' => true]);
}

// CartController.php

public function checkStock(Request $request)
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)->first();

    foreach ($cart->cartItems as $item) {
        $product = Product::find($item->product_id);
        if ($product->quantity < $item->quantity) {
            return redirect()->back()->withErrors([
                'message' => "Sản phẩm {$product->name} chỉ còn {$product->quantity} cái, bạn cần cập nhật giỏ hàng."
            ]);
        }
    }

    // Nếu đủ số lượng → chuyển sang trang thanh toán
    return redirect()->route('client.checkout.index');
}
}
