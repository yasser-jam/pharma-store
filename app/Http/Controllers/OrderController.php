<?php

namespace App\Http\Controllers;

use App\Events\sent;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{  /**
    * Place a new order.
    */
   public function store(StoreOrderRequest $request)
   {
       $order = Order::create([
           'user_id' => auth()->user()->id,
       ]);
       foreach ($request->input('items') as $item) {
           OrderItem::create([
               'order_id' => $order->id,
               'medcine_id' => $item['medcine_id'],
               'qtn_requested' => $item['qtn'],
           ]);
       }

       return response()->json(['message' => 'Order placed successfully']);
   }

   /**
    * View orders for the authenticated pharmacy user.
    */
   public function index()
   {
       $orders = Order::where('user_id', auth()->user()->id)->get();
       return response()->json(['orders' => $orders]);
   }

   /**
    * View all orders from the warehouse perspective.
    */
   public function viewAllOrders()
   {
       $orders = Order::all();
       return response()->json(['orders' => $orders]);
   }

   /**
    * Update the status of an order.
    */
   public function updateStatus($orderId, $status)
   {
       $order = Order::findOrFail($orderId);
       if($status === 'sent'){
           event(new sent($order));
       }

       $order = Order::findOrFail($orderId);
       $order->status = $status;
       $order->save();

       return response()->json(['message' => 'Order status updated']);
   }

   /**
    * Update the billing status of an order.
    */
   public function updateBillingStatus($orderId, $billingstatus)
   {

       $order = Order::findOrFail($orderId);
       $order->billingstatus = $billingstatus;
       $order->save();

       return response()->json(['message' => 'Payment status updated']);
   }
}
