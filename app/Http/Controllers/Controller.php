<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    use AuthorizesRequests , ValidatesRequests;

    public function response( $data):JsonResponse
    {
        return response()->json([
            'data'=>$data
        ]);
    }
    public function success(string $message, $data=null):JsonResponse
    {
        return response()->json([
            'status'=>'success',
            'success'=>true,
            'messgae'=>$message ?? "operation successfull ",
            'data'=>$data,
        ]); 
    }
    public function error(string $message, $data=null):JsonResponse
    {
        return response()->json([
            'status'=>'error',
            'success'=>false,
            'messgae'=>$message ?? "error occured",
            'data'=>$data,
        ]);
    }

}
