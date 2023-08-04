<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Travel extends BaseModel
{
    use HasFactory;

    protected $table = 'travels';

    protected $casts = [
        'is_public' => 'bool'
    ];

    protected static function booted()
    {
        static::created(function (Travel $travel) {
            $travel->slug = Str::slug($travel->name) . '_' . $travel->id;
            $travel->save();
        });

        static::updating(function (Travel $travel) {
            $travel->slug = Str::slug($travel->name) . '_' . $travel->id;
        });
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::get(function (){
            return $this->number_of_days - 1;
        });
    }

    public function scopePublic(Builder $builder)
    {
        $builder->where('is_public', true);
    }
}
