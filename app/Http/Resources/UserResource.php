<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {

        // dd(UserSettingResource::collection($this->settings));
        return [
            "id"=> $this->id,
            "first_name"=> $this->first_name,
            "last_name"=> $this->last_name,
            'full_name'=>$this->last_name.' '. $this->first_name,
            "email"=> $this->email,
            "phone"=> $this->phone,
            'settings'=>UserSettingResource::collection($this->settings),
            "created_at"=>$this->created_at,
        ];
    }
}
