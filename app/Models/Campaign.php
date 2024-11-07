<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class);
    }

    public function utmCampaign(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => json_decode('"' . $value . '"')
        );
    }
}
