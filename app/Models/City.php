<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table      = 'cities';
    public    $timestamps = false;

    protected $fillable = [
        'country_code',
        'name',
        'api_response',
    ];

    protected $guarded = [
        'user_id'
    ];

    //Relationships
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //Accessors
    public function getCurrentResponseAttribute($value)
    {
        return $value && is_string($value) ? json_decode($value) : $value;
    }

    public function getForecastResponseAttribute($value)
    {
        return $value && is_string($value) ? json_decode($value) : $value;
    }
}
