<?php

namespace App\Http\Controllers\User\Payment;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoMoController extends Controller
{
    /**
     * Trang thành công
     */
    public function success($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId);
        return view('user.payment.success', compact('order'));
    }
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
        
    /**
     * Xử lý thanh toán đơn hàng
     */
    public function processPayment(Request $request)
    {
        // Validate
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email',
            'user_phone' => 'required|string|max:20',
            'user_address' => 'required|string',
            'payment_method' => 'required|in:cod,momo',
        ], [
            'user_name.required' => 'Vui lòng nhập họ tên',
            'user_email.required' => 'Vui lòng nhập email',
            'user_phone.required' => 'Vui lòng nhập số điện thoại',
            'user_address.required' => 'Vui lòng nhập địa chỉ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        // Lấy giỏ hàng
        $userId = Auth::check() ? Auth::id() : null;
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $cartItems = $cart->items()->with(['variant.product'])->get();

        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $product = $item->variant->product;
            $price = $product->price_sale ?? $product->price;
            $totalPrice += $price * $item->quantity;
        }

        // Validate min/max amount
        if ($totalPrice < 1000) {
            return back()->with('error', 'Số tiền thanh toán tối thiểu 1,000đ');
        }
        if ($totalPrice > 50000000) {
            return back()->with('error', 'Số tiền thanh toán tối đa 50,000,000đ');
        }

        try {
            DB::beginTransaction();

            // Tạo Order
            $order = Order::create([
                'user_id' => $userId,
                'user_name' => $request->user_name,
                'user_email' => $request->user_email,
                'user_phone' => $request->user_phone,
                'user_address' => $request->user_address,
                'user_note' => $request->user_note,
                'total_price' => $totalPrice,
                'status_order' => 'pending',
                'status_payment' => 'unpaid',
                'is_ship_user_same_user' => true,
            ]);

            // Tạo OrderItems & giảm stock
            foreach ($cartItems as $item) {
                $product = $item->variant->product;
                $price = $product->price_sale ?? $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku ?? 'N/A',
                    'product_img_thumbnail' => $product->img_thumbnail,
                    'product_price' => $price,
                    'variant_size_name' => $item->variant->size,
                    'variant_color_name' => $item->variant->color,
                    'quantity' => $item->quantity,
                    'item_total' => $price * $item->quantity,
                    'status' => 'pending',
                ]);

                // Giảm stock
                $item->variant->decrement('quantity', $item->quantity);
            }

            DB::commit();

            // Xóa giỏ hàng
            $cart->items()->delete();

            // Redirect theo phương thức thanh toán
            if ($request->payment_method === 'momo') {
                // Task 24 sẽ implement MoMo API call
                // Tạm thời redirect success
                return redirect()->route('payment.success', $order->id);
            } else {
                // COD: Redirect success page
                return redirect()->route('payment.success', $order->id)
                    ->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Error', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    /**
     * Trang thanh toán thất bại
     */
    public function failed($orderId)
    {
        // Lấy order
        $order = Order::with('orderItems')->findOrFail($orderId);

        // Verify ownership (nếu login)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này');
        }

        return view('user.payment.failed', compact('order'));
    }
}