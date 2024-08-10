<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result=[
            "stock_id"=> $this->id,
            'quantity'=> $this->quantity,
            // "color"=>'red',
            // 'material'=>"MDF"
        ];

       
        return $this->getAttributes($result);
    }

    public function getAttributes(array $result):array
    {
        $attributes=json_decode($this->attributes);
        
        foreach ($attributes as $StockAttributes) {
            $attribute = Attribute::find($StockAttributes->attribute_id);

            $attributeData = $attribute->getAttributes();
            $attributeName = $attributeData['name'];

            $value = Value::find($StockAttributes->value_id);
            
            $result[$attributeName] = $value->getTranslations('name');
        }
        return $result;
    }
}
