<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    
        
         public function index()
        {
            $user = auth()->user(); 
            return response()->json($user->favorites);
        }
        public function store(Request $request){
           
            $user = auth()->user()->favorites()->attach($request->product_id);
            return $this->success('user auth',$user)

        }

        public function destroy($favorite_id)
        {
            $user = auth()->user();
    
            if ($user->hasFavorite($favorite_id)) {
               $user->favorites()->detach($favorite_id);
               return response()->json([
                "success"=>true
               ]);            
            }
    
            return $this->error("Favorite not found.",[$user]);
        }

}
