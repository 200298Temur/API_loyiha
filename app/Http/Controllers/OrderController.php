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



    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreOrderRequest $request)
    // {
    //     $sum=0;
    //     $products=[];
    //     $address=UserAddress::find($request->address_id);
        

    //         foreach($request['products'] as $product){
    //             $prod=Product::with('stocks')->findOrFail($product['product_id']);

    //             if(
    //                 $prod->stocks()->find($product['stock_id']) &&  
    //                 $prod->stocks()->find($product['stock_id'])->quantity >=$product['quantity ']
    //             ){
    //                     $p=$prod->withStock(1);
    //                     dd($p);
    //             }   
    //             // dd($product);
    //             dd($prod->stocks());
    //         }

    //     auth()->user()->orders()->create([
    //         "comment"=>$request->comment,
    //         "delivery_method_id"=>$request->delivery_method_id,
    //         "payment_type_id"=>$request->payment_type_id,
    //         "address"=>$address,
    //         "sum"=>$request->sum,
    //         "products"=>$products
    //     ]);
    //     return "success";
    //     // dd($re   quest);
    // }
    // public function store(StoreOrderRequest $request)
    // {
    //     $sum = 0;
    //     $products = [];
    //     $noteFoundProducts=[];
    //     $address = UserAddress::find($request->address_id);
    
    //     // Ensure 'products' key exists and is iterable
    //     if (isset($request['products']) && is_array($request['products'])) {
    //         foreach ($request['products'] as $product) {
    //             // Ensure the necessary keys exist in each product
    //             if (isset($product['product_id'], $product['stock_id'], $product['quantity'])) {
    //                 $prod = Product::with('stocks')->findOrFail($product['product_id']);
    //                 $prod->quantity=$product['quantity'];

    //                 $stock = $prod->stocks()->find($product['stock_id']);
    //                 if ($stock && $stock->quantity >= $product['quantity']) 
    //                 {
    //                     $ProductResource=new ProductResource($prod->withStock($product['stock_id']));
                        
    //                     // dd($ProductResource['price']);
    //                     $sum+=$ProductResource['price'];
    //                     $products[]=$ProductResource->resolve();
    //                 }else{
    //                     $noteFoundProducts[]=$product;
    //                     $noteFoundProducts['we_have']=$prod->stocks()->find($product['stock_id'])->quantity;
    //                 }
    //             } 
    //         }
    //     } else {
    //         // Handle empty or invalid 'products' array
    //         throw new \Exception('No products found in the request');
    //     }

    //      if($noteFoundProducts == null && $products!=[] && $sum == 0){

    //     $res=auth()->user()->orders()->create([
    //         "comment" => $request->comment,
    //         "delivery_method_id" => $request->delivery_method_id,
    //         "payment_type_id" => $request->payment_type_id,
    //         "address" => $address,
    //         "sum" => $request->sum,
    //         'status_id'=>in_array($request['payment_type_id'],[1,2])?1:10,
    //         'address'=>$address,
    //         "products" => $products
    //     ]);
        
    
    //       if ($res) {
    //         foreach ($products as $product) {
    //         // Ensure the inventory ID and order quantity exist
    //         $stock = Stock::find($product['inventory'][0]['id']);
            
    //         // Ensure the stock is found
            
    //         $stock->quantity -= $product['order_quantity'];
    //         $stock->save();
                        
    //             }
    //         }
                
    //             return "success";
    //         }else{
    //             return response([
    //                 'succcses'=>false,
    //                 'message'=>'some products not found or does note have inventory',
    //                 'not_found_products'=>$noteFoundProducts,
    //             ]);
    //         }
            
    //     return "smething went wrong, cant create order";
    // }
       
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
