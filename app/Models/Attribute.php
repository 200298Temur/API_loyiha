<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasFactory;
    // HasTranslations;
    protected $fillable = [
        "name"
    ];
    // public $translatable = ['name'];

    public function values():MorphMany
    {
        return $this->morphMany(Value::class,'valueable');
    }
}
