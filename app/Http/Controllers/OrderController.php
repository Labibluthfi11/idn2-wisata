<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // GET: Ambil semua data order
    public function index()
    {
        try {
            $orders = Order::all();
            return response()->json($orders, 200);
        } catch (\Exception $e) {
            Log::error("Error fetching orders: " . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch orders'], 500);
        }
    }

    // POST: Simpan data order baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'transaction_time' => 'required|date',
                'total_price' => 'required|numeric',
                'total_item' => 'required|integer',
                'payment_amount' => 'required|numeric',
                'cashier_id' => 'required|integer',
                'cashier_name' => 'required|string',
                'payment_method' => 'required|string'
            ]);
    
            $order = Order::create($request->only([
                'transaction_time', 'total_price', 'total_item', 
                'payment_amount', 'cashier_id', 'cashier_name', 'payment_method'
            ]));
    
            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            Log::error("Error creating order: " . $e->getMessage());
            return response()->json(['message' => 'Failed to create order'], 500);
        }
    }

    // GET: Ambil satu data order berdasarkan ID
    public function show($id)
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
            return response()->json($order, 200);
        } catch (\Exception $e) {
            Log::error("Error fetching order ID {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch order'], 500);
        }
    }

    // PUT/PATCH: Update data order berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $request->validate([
                'transaction_time' => 'sometimes|date',
                'total_price' => 'sometimes|numeric',
                'total_item' => 'sometimes|integer',
                'payment_amount' => 'sometimes|numeric',
                'cashier_id' => 'sometimes|integer',
                'cashier_name' => 'sometimes|string',
                'payment_method' => 'sometimes|string'
            ]);

            $order->update($request->only([
                'transaction_time', 'total_price', 'total_item', 
                'payment_amount', 'cashier_id', 'cashier_name', 'payment_method'
            ]));

            return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
        } catch (\Exception $e) {
            Log::error("Error updating order ID {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Failed to update order'], 500);
        }
    }

    // DELETE: Hapus data order berdasarkan ID
    public function destroy($id)
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $order->delete();
            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error("Error deleting order ID {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Failed to delete order'], 500);
        }
    }
}
