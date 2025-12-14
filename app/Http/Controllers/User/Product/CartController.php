<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ], [
            'product_id.required' => 'Thiếu ID sản phẩm',
            'product_id.exists' => 'Sản phẩm không tồn tại',
            'size.required' => 'Vui lòng chọn size',
            'color.required' => 'Vui lòng chọn màu',
            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.min' => 'Số lượng phải >= 1',
        ]);

        try {
            DB::beginTransaction();

            // Tìm variant phù hợp
            $variant = ProductVariant::where('product_id', $request->product_id)
                ->where('size', $request->size)
                ->where('color', $request->color)
                ->firstOrFail();

            // Kiểm tra tồn kho
            if ($variant->quantity < $request->quantity) {
                return back()->with('error', 'Không đủ hàng trong kho! Chỉ còn ' . $variant->quantity . ' cái');
            }

            // Tạo/lấy giỏ hàng (tạm thời dùng session_id nếu chưa login)
            $userId = Auth::check() ? Auth::id() : null;
            $sessionId = session()->getId();

            // Nếu login, lấy cart by user_id
            if ($userId) {
                $cart = Cart::firstOrCreate(
                    ['user_id' => $userId],
                    ['user_id' => $userId]
                );
            } else {
                // Nếu chưa login, dùng session_id (lưu vào model bằng cách khác hoặc tạm thời dùng user_id = null)
                $cart = Cart::firstOrCreate(
                    ['user_id' => null],
                    ['user_id' => null]
                );
            }

            // Kiểm tra cart item đã có chưa
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $variant->id)
                ->first();

            if ($cartItem) {
                // Nếu đã có, tăng số lượng
                $newQuantity = $cartItem->quantity + $request->quantity;

                // Kiểm tra lại stock
                if ($variant->quantity < $newQuantity) {
                    return back()->with('error', 'Không đủ hàng! Chỉ còn ' . $variant->quantity . ' cái');
                }

                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                // Nếu chưa có, tạo mới
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $request->quantity
                ]);
            }

            DB::commit();
            
            return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
 * Hiển thị giỏ hàng
 */
public function index()
{
    // Lấy giỏ hàng (dùng user_id = null nếu chưa login)
    $userId = Auth::check() ? Auth::id() : null;
    $cart = Cart::where('user_id', $userId)->first();

    if (!$cart) {
        return view('user.cart.index', ['cartItems' => [], 'totalPrice' => 0]);
    }

    // Lấy cart items với eager loading
    $cartItems = $cart->items()
        ->with(['variant.product'])
        ->get();

    // Tính tổng tiền
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $product = $item->variant->product;
        $price = $product->price_sale ?? $product->price;
        $totalPrice += $price * $item->quantity;
    }

    return view('user.cart.index', compact('cartItems', 'totalPrice'));
}

/**
 * Cập nhật số lượng
 */
public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ], [
        'quantity.required' => 'Vui lòng nhập số lượng',
        'quantity.min' => 'Số lượng phải >= 1',
    ]);

    try {
        // Lấy giỏ hàng
        $userId = Auth::check() ? Auth::id() : null;
        $cart = Cart::where('user_id', $userId)->firstOrFail();

        // Lấy cart item
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $id)
            ->with('variant.product')
            ->firstOrFail();

        // Kiểm tra stock
        if ($cartItem->variant->quantity < $request->quantity) {
            return back()->with('error', 'Không đủ hàng! Chỉ còn ' . $cartItem->variant->quantity . ' cái');
        }

        // Cập nhật
        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cập nhật số lượng thành công!');

    } catch (\Exception $e) {
        return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}

    /**
     * Helper: Lấy hoặc tạo giỏ hàng
     */
    private function getOrCreateCart()
    {
        if (!Auth::check()) {
            return null;
        }

        return Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );
    }
}