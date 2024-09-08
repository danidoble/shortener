<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends Model
{
    use HasFactory, SoftDeletes;

    public function getRouteKeyName(): string
    {
        return 'shortened_url';
    }

    protected $fillable = [
        'title',
        'url',
        'shortened_url',
        'visits',
        'visits_qr',
        'last_visited',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class);
    }

    public function statistics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class);
    }

    public function statistics7days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class)->where('created_at', '>=', now()->subDays(7));
    }

    public function statisticsPrevious7days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class)->where('created_at', '>=', now()->subDays(14))->where('created_at', '<=', now()->subDays(7));
    }

    public function qrStatistics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class)->where('type', 'qr');
    }

    public function qrStatistics7days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class)->where('type', 'qr')->where('created_at', '>=', now()->subDays(7));
    }

    public function qrStatisticsPrevious7days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlLog::class)->where('type', 'qr')->where('created_at', '>=', now()->subDays(14))->where('created_at', '<=', now()->subDays(7));
    }
}
