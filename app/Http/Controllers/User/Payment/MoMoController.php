<?php

namespace App\Http\Controllers\User\Payment;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoMoController extends Controller
{
    /**
     * Hiển thị trang checkout
     */
    public function showCheckout()
    {
        // Lấy giỏ hàng
        $userId = Auth::check() ? Auth::id() : null;
        $cart = Cart::where('user_id', $userId)->first();

        // Kiểm tra giỏ hàng có items
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống! Vui lòng thêm sản phẩm');
        }

        // Lấy cart items
        $cartItems = $cart->items()->with(['variant.product'])->get();

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $product = $item->variant->product;
            $price = $product->price_sale ?? $product->price;
            $totalPrice += $price * $item->quantity;
        }

        return view('user.payment.checkout', compact('cartItems', 'totalPrice'));
    }
}