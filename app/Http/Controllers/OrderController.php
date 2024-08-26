<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        if(request()->has('status_id'))
        {
            return $this->response(OrderResource::collection(
                auth()->user()->orders()->where('status_id',request("status_id"))->paginate(10)
            ));    
        }

        return $this->response(OrderResource::collection(
            auth()->user()->orders()->paginate(10)
        ));    
    }

    public function create()
    {
        //
    }

    public function store(StoreOrderRequest $request)
    {
    $sum = 0;
    $products = [];
    $noteFoundProducts = [];
    $address = UserAddress::find($request->address_id);

    if (isset($request['products']) && is_array($request['products'])) {
        foreach ($request['products'] as $product) {
            if (isset($product['product_id'], $product['stock_id'], $product['quantity'])) {
                $prod = Product::with('stocks')->find($product['product_id']);
                
                if ($prod) {
                    $stock = $prod->stocks()->find($product['stock_id']);
                    if ($stock && $stock->quantity >= $product['quantity']) {
                        $prod->quantity = $product['quantity'];
                        $ProductResource = new ProductResource($prod->withStock($product['stock_id']));
                        $sum += $ProductResource['price'] * $product['quantity'];
                        $products[] = $ProductResource->resolve();
                    } else {
                        $noteFoundProducts[] = [
                            'product' => $product,
                            'available_quantity' => $stock ? $stock->quantity : 0
                        ];
                    }
                } else {
                    $noteFoundProducts[] = $product;
                }
            }
        }

        if (empty($noteFoundProducts) && !empty($products) && $sum > 0) {
            $res = auth()->user()->orders()->create([
                "comment" => $request->comment,
                "delivery_method_id" => $request->delivery_method_id,
                "payment_type_id" => $request->payment_type_id,
                "address" => $address,
                "sum" => $sum,
                'status_id' => in_array($request['payment_type_id'], [1, 2]) ? 1 : 10,
                "products" => $products
            ]);

            if ($res) {
                foreach ($products as $product) {
                    $stock = Stock::find($product['inventory'][0]['id']);
                    if ($stock) {
                        $stock->quantity -= $product['order_quantity'];
                        $stock->save();
                    }
                }
            }
            return $this->success('order created',$res);
        } else {
            // return response([
            //     'success' => false,
            //     'message' => 'Some products are not available or have insufficient stock',
            //     'not_found_products' => $noteFoundProducts,
            // ]);

            return $this->error("Some products are not available or have insufficient stock",
              ['not_found_products' => $noteFoundProducts]
            );
        }
    } else {
        throw new \Exception('No products found in the request');
    }

    return $this->success("Something went wrong, order could not be created");
}

       
    public function show(Order $order):JsonResponse
    {
        return $this->response(new OrderResource($order));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    { 
        $order->delete();
        return 1;   
    }
}
