<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Resources\CustomerOrderResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ResponseResource;
use App\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customerId)
    {
        $order = Customer::with('orders')
            ->find($customerId);
        return (new CustomerOrderResource($order))->additional(['message' => 'Berhasil']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $customerId)
    {
        $valid = $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required',
            'note' => 'required',
            'paid' => 'required',
            'total_order' => 'required',
            'change' => 'required',
            'order_products' => 'required',
            'order_products.*.product_id' => 'required',
            'order_products.*.quantity' => 'required',
            'order_products.*.total' => 'required'
        ]);

        $customer = Customer::find($customerId);

        if ($customer != null) {

            $order = $customer->orders()->firstOrCreate([
                'user_id' => $request->user_id,
                'order_date' => $request->order_date,
                'paid' => $request->paid,
                'change' => $request->change,
                'total_order' => $request->total_order,
                'note' => $request->note,
            ]);

            foreach ($valid['order_products'] as $data) {
                $order->orderProduct()->insert([
                    'order_id' => $order->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'total' => $data['total']
                ]);
            }

            if ($order != null) {
                return (new OrderResource($order))
                    ->additional(['message' => 'Berhasil'])
                    ->response()
                    ->setStatusCode(201);
            }
        }

        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($customerId, $orderId = null)
    {
        $customer = Customer::find($customerId);

        if ($customerId != null && $orderId != null) {
            $order = Order::with('orderProduct', 'orderProduct.product', 'orderProduct.product.category')
                ->where('customer_id', $customerId)
                ->where('id', $orderId)
                ->first();
            if ($order != null) {
                return (new OrderResource($order))->additional(['message' => 'Berhasil']);
            }
        }
        if ($customer != null && !isset($orderId)) {
            return (new CustomerResource($customer))
                ->additional(['message' => 'Berhasil']);
        }
        return (new ResponseResource(null, 'Tidak ada'))
            ->response()
            ->setStatusCode(400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($orderId)
    {
        $order = Order::find($orderId);
        if ($order == null) {
            return (new ResponseResource(null, 'Order tidak ada'))
                ->response()
                ->setStatusCode(400);
        }
        if ($order->delete()) {
            return (new ResponseResource($order, 'Berhasil'))
                ->response()
                ->setStatusCode(204);
        }
        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);
    }
}
