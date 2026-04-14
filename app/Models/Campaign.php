<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Campaign extends Model
{
    protected $fillable = [
        'user_id', 
        'category_id', 
        'title', 
        'slug', 
        'description', 
        'image', 
        'target_amount', 
        'current_amount', 
        'end_date', 
        'status'
    ];

    protected static function booted()
    {
        static::deleting(function ($campaign) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
        });
    }

    public function user() {
        return $this->belongsTo(User::class); 
    }

    public function category() {
        return $this->belongsTo(DisasterCategory::class, 'category_id'); 
    }
    public function impact() { 
        return $this->hasOne(DisasterImpact::class); 
    }

    public function donations() { 
        return $this->hasMany(Donation::class);
    }

    public function documentations() {
        return $this->hasMany(Documentation::class); 
    }
}
