<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrlLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'url_id',
        'shortened_url',
        'url',
        'ip_address',
        'user_agent',
        'referer',
        'country',
        'country_code',
        'region',
        'region_code',
        'continent_name',
        'type',
    ];

    public function url(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
