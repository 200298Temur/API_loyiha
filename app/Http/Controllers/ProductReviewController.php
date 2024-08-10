<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{

    public function index(Product $product){

        return $this->response([
            'overall_rating'=>round($product->reviews()->avg('rating'),1),
            'reviews_count'=>$product->reviews()->count(),
            'reviews'=>$product->reviews()->with('user')->paginate(10),
        ]);
    }
    public function store(Product $product,StoreReviewRequest $storeReviewRequest){
        $product=$product->reviews()->create([
            'user_id'=>auth()->id(),
            'rating'=>$storeReviewRequest->rating,
            "body"=>$storeReviewRequest->body,
        ]);
        return $this->success('review created',$product);
    }
}
