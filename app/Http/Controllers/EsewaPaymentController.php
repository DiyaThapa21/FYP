<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Str;
use Helper;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\User;
use Xentixar\EsewaSdk\Esewa;

class EsewaPaymentController extends Controller
{
    public function pay(Request $request)
    {
        try {
            session([
                'checkout_data' => $request->all(),
            ]);
            $transactionUuid = uniqid('txn_' . microtime(true) . '_', true);

            $sum = Helper::totalCartPrice();


            if ($sum > 0) {

                $esewa = new Esewa();

                $esewa->config(route('esewa.check'), route('esewa.check'), $sum, $transactionUuid);
                $esewa->init();
            } else {
                return redirect()->back()->with('error', 'Invalid payment amount.');
            }
        } catch (\Exception $e) {
            dd('Error during payment initialization:', $e->getMessage());
        }
    }


    public function check(Request $request)
    {
        $esewa = new Esewa();
        $data = $esewa->decode();


        if ($data && $data['status'] === 'COMPLETE') {
            if (Cart::where('user_id', auth()->id())->whereNull('order_id')->doesntExist()) {
                return redirect()->route('cart.index')->with('error', 'Cart is Empty!');
            }

            $checkoutData = session('checkout_data'); // retrieve saved checkout form

            if (!$checkoutData) {
                return redirect()->route('cart.index')->with('error', 'Session expired. Please try again.');
            }

            $shippingPrice = Shipping::where('id', $checkoutData['shipping'])->value('price') ?? 0;
            $couponValue = session('coupon')['value'] ?? 0;

            $order = new Order();
            $order_data = [
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'shipping_id' => $checkoutData['shipping'],
                'first_name' => $checkoutData['first_name'],
                'last_name' => $checkoutData['last_name'],
                'email' => $checkoutData['email'],
                'phone' => $checkoutData['phone'],
                'country' => $checkoutData['country'],
                'address1' => $checkoutData['address1'],
                'address2' => $checkoutData['address2'],
                'post_code' => $checkoutData['post_code'],
                'sub_total' => Helper::totalCartPrice(),
                'quantity' => Helper::cartCount(),
                'notes' => Cart::where('user_id', auth()->id())->whereNull('order_id')->pluck('notes')->filter()->implode(', '),
                'coupon' => $couponValue,
                'total_amount' => Helper::totalCartPrice() + $shippingPrice - $couponValue,
                'status' => 'new',
                'payment_method' => 'esewa',
                'payment_status' => 'paid',
            ];

            $order->fill($order_data);
            $order->save();

            // Save cart items
            $cartItems = Cart::where('user_id', auth()->id())->whereNull('order_id')->get();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'color' => $item->color,
                    'size' => $item->size,
                    'total' => $item->quantity * $item->price,
                ]);
            }

            Cart::where('user_id', auth()->id())->whereNull('order_id')->update(['order_id' => $order->id]);

            // Handle Rewards
            $rewardPoints = floor($order_data['total_amount'] / 100) * 10;
            $expenseAmount = $order_data['total_amount'];

            $userReward = \App\Models\UserRewards::firstOrNew(['user_id' => $order->user_id]);
            $userReward->reward_point = ($userReward->reward_point ?? 0) + $rewardPoints;
            $userReward->total_expenses = ($userReward->total_expenses ?? 0) + $expenseAmount;
            $userReward->type = $userReward->total_expenses >= 8000 ? 2 : ($userReward->total_expenses >= 5000 ? 1 : 0);
            $userReward->save();

            session()->forget('checkout_data'); // Clear checkout session
            request()->session()->flash('success', 'Your order has been placed successfully!');
            return redirect()->route('order.success', ['id' => $order->id]);
        }

        return redirect()->route('payment-failed')->with('error', 'Payment verification failed.');
    }
}
