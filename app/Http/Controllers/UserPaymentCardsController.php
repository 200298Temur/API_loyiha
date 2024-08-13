<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPaymentCardsRequest;
use App\Http\Requests\UpdateUserPaymentCardsRequest;
use App\Http\Resources\UserPaymentCardResource;
use App\Models\UserPaymentCards;

class UserPaymentCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  $this->response(UserPaymentCardResource::collection(auth()->user()->paymentCards));
    }

   
    public function create()
    {
        //
    }

    public function store(StoreUserPaymentCardsRequest $request)
    {
        //  dd($request->all());
        $card = auth()->user()->paymentCards()->create([
            "name" => encrypt($request->name),
            "number" => encrypt($request->number),
            "exp_data" => encrypt($request->exp_data), 
            "holder_name" => encrypt($request->holder_name),
            "last_four_number" => encrypt(substr($request->number, -4)),
            "payment_card_type_id" => $request->payment_card_type_id,
        ]);
        return $this->success('card added');
    }
    

    public function show(UserPaymentCards $userPaymentCards)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPaymentCards $userPaymentCards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPaymentCardsRequest $request, UserPaymentCards $userPaymentCards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPaymentCards $userPaymentCards)
    {
        //
    }
}
