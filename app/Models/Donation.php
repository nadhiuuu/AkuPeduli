<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'id',
        'campaign_id',
        'user_id',
        'order_id',
        'gross_amount',
        'donor_name',
        'is_anonymous',
        'message',
        'status',
        'payment_type',
        'snap_token'
    ];

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
