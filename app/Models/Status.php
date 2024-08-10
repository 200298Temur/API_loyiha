<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Status extends Model
{
    use HasFactory,HasTranslations;   
    protected $fillable=["name","for"];
    protected array $translatable=["name"];

    public function oeder():HasMany
    {
        return $this->hasMany(Order::class); 
    }
}
