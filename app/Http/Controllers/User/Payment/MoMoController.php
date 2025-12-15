<?php

namespace App\Http\Controllers\User\Payment;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoMoController extends Controller
{
    private $endpoint;
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $redirectUrl;
    private $ipnUrl;

    public function __construct()
    {
        $this->endpoint = config('services.momo.endpoint');
        $this->partnerCode = config('services.momo.partner_code');
        $this->accessKey = config('services.momo.access_key');
        $this->secretKey = config('services.momo.secret_key');
        $this->redirectUrl = config('services.momo.redirect_url');
        $this->ipnUrl = config('services.momo.ipn_url');
    }

    /**
     * Hiển thị trang checkout
     */
    public function showCheckout()
    {
        $cart = Cart::with('items.variant.product')->where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        
        $cartItems = $cart->items;
        $totalPrice = $this->calculateCartTotal($cartItems);
        
        return view('user.payment.checkout', compact('cartItems', 'totalPrice'));
    }

    /**
     * Tính tổng tiền giỏ hàng
     */
    private function calculateCartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $item->variant->product;
            $price = $product->price_sale ?? $product->price;
            $total += $price * $item->quantity;
        }
        return $total;
    }

    /**
     * Xử lý thanh toán
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'user_name'      => 'required|string|max:255',
            'user_phone'     => 'required|string|max:20',
            'user_email'     => 'required|email',
            'user_address'   => 'required|string',
            'payment_method' => 'required|in:cod,momo',
        ]);

        $cart = Cart::with('items.variant.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $cartItems = $cart->items;
        $totalPrice = $this->calculateCartTotal($cartItems);

        if ($totalPrice < 1000) {
            return back()->with('error', 'Số tiền thanh toán tối thiểu là 1,000đ!');
        }

        if ($totalPrice > 50000000) {
            return back()->with('error', 'Số tiền thanh toán vượt quá giới hạn 50,000,000đ!');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id'                => Auth::id(),
                'user_name'              => $request->user_name,
                'user_email'             => $request->user_email,
                'user_phone'             => $request->user_phone,
                'user_address'           => $request->user_address,
                'user_note'              => $request->user_note,
                'total_price'            => $totalPrice,
                'status_order'           => 'pending',
                'status_payment'         => 'unpaid',
                'is_ship_user_same_user' => true,
            ]);

            foreach ($cartItems as $item) {
                $product = $item->variant->product;
                $price = $product->price_sale ?? $product->price;

                OrderItem::create([
                    'order_id'              => $order->id,
                    'product_variant_id'    => $item->product_variant_id,
                    'product_name'          => $product->name,
                    'product_sku'           => $product->sku ?? 'N/A',
                    'product_img_thumbnail' => $product->img_thumbnail,
                    'product_price'         => $price,
                    'variant_size_name'     => $item->variant->size ?? '',
                    'variant_color_name'    => $item->variant->color ?? '',
                    'quantity'              => $item->quantity,
                    'item_total'            => $price * $item->quantity,
                    'status'                => 'pending',
                ]);

                $item->variant->decrement('quantity', $item->quantity);
            }

            DB::commit();

           // COD - direct success
            $cart->items()->delete();

            return redirect()->route('payment.success', $order->id)
                ->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm để xác nhận.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
    }


    /**
     * Trang thành công
     */
    public function success($orderId)
    {
        $order = Order::with('orderItems.variant.product')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.payment.success', compact('order'));
    }

    /**
     * Trang thất bại
     */
    public function failed($orderId)
    {
        $order = Order::with('orderItems.variant.product')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.payment.failed', compact('order'));
    }
}