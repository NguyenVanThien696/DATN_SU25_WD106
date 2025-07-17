<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductReview;

class ProductController extends Controller
{
    public function index()
    {
        $listProducts = Product::with(['tag', 'variants.size', 'variants.color'])->latest()->paginate(12);
        $breadcrumbs = [
            (object)['name' =>  'Cửa hàng', 'route' =>route('client.products.index')],
        ];
        return view('client.products.index', compact('listProducts', 'breadcrumbs'));
    }

    // ShopController
    public function show($id)
    {
        $product = Product::with(['variants.size', 'variants.color', 'category', 'brand', 'reviews.user'])->findOrFail($id);

        $variants = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'size_id' => $variant->size_id,
                'color_id' => $variant->color_id,
                'stock' => $variant->stock,
            ];
        });

        $stock = $variants->sum('stock');

        $canReviewItems = [];

        if (Auth::check()) {
            $userId = Auth::id();

            // Lấy các order items mà user đã mua và chưa đánh giá
            $purchasedItems = OrderItem::with('productVariant')
                ->whereHas('order', function ($q) use ($userId) {
                    $q->where('user_id', $userId)->where('status', 'completed');
                })
                ->whereHas('productVariant', function ($q) use ($product) {
                    $q->where('product_id', $product->id);
                })
                ->get();

            foreach ($purchasedItems as $item) {
                $alreadyReviewed = ProductReview::where('order_item_id', $item->id)->exists();

                if (!$alreadyReviewed) {
                    $canReviewItems[] = $item;
                }
            }
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->latest()->take(4)->get();

        return view('client.products.detail', compact(
            'product',
            'variants',
            'stock',
            'relatedProducts',
            'canReviewItems'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('s') ?? $request->input('keyword');

        if (!$keyword) {
            return view('client.search.index', ['products' => collect(), 'keyword' => $keyword]);
        }

        $keywords = explode(' ', $keyword);

        $products = Product::query();

        foreach ($keywords as $word) {
            $products->where(function ($query) use ($word) {
                $query->where('name', 'LIKE', '%' . $word . '%')->orWhere('description', 'LIKE', '%' . $word . '%');
            });
        }

        $products = $products->get();

        return view('client.search.index', compact('products', 'keyword'));
    }
}
