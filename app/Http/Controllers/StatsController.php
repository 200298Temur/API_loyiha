<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;

class StatsController extends Controller
{
    public function ordersCount(Request $request){
        $from=Carbon::now()->subMonth();
        $to=Carbon::now();

        if($request->has(['from','to'])){
            $from=$request->from;
            $to=$request->to;
        }

        return $this->response(
            Order::query()->
            whereBetween('created_at',[$from,$to])->
            whereRelation('status','code','colosed')
            ->count()
        );
    }

    public function orderSalesSum(Request $request){
       
         $from=Carbon::now()->subMonth();
        $to=Carbon::now();

        if($request->has(['from','to'])){
            $from=$request->from;
            $to=$request->to;
        }

       
        return $this->response(
            Order::query()->
            whereBetween('created_at',[$from,$to])->
            whereRelation('status','code','colosed')->
            sum('sum')
        );
    }

    public function deliveryMethodsRatio(Request $request)
    {
        // if(Cache::has("deliveryMethodsRatio")){
        //     return Cache::get('deliveryMethodsRatio');
        // }
        
        $from=Carbon::now()->subMonth();
        $to=Carbon::now();
       
        if ($request->has(['from', 'to'])) {
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
        }

        $response=[];
        $allOrders=Order::query()->
        whereBetween('created_at',[$from,$to])->
        whereRelation('status','code','colosed')
        ->count();
        
        foreach(DeliveryMethod::all() as $delivery)
        {
           $deliveryOrder= $delivery->orders()->
           whereBetween('created_at',[$from,$to])->
           whereRelation('status','code','colosed')
           ->count();

            $response[]=[
                'name'=>$delivery->getTranslations('name'),
                'percentage'=>round($allOrders!=0 ? $deliveryOrder*100/$allOrders:0,2),
                'amount'=>$deliveryOrder,
            ];
        }

        // Cache::put('deliveryMethodsRatio',$response,Carbon::now()->addDay());
        
        return $this->response($response);
    }

    public function ordersCountByDays(Request $request)
    {
        $from=Carbon::now()->subMonth();
        $to=Carbon::now();

        if($request->has(['from','to'])){
            $from=$request->from;
            $to=$request->to;
        }

        $days=CarbonPeriod::create($from,$to);

        $response=new Collection;

        LazyCollection::make($days->toArray())->each(function ($day) use ($from,$to,$response) {
            $count=Order::query()->
            where('created_at',$day)->
            whereRelation('status','code','colosed')->
            count();

            $response[]=[
                'data'=>$day->format('Y-m-d'),
                'orders_count'=>$count,
            ];
        });

        return $this->response($response);
    }
}
