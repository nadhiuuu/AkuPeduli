<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use DeletesStoredFiles;

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

    protected static function booted(): void
    {
        static::updating(function (self $campaign): void {
            if (! $campaign->isDirty('image')) {
                return;
            }

            $oldImage = $campaign->getOriginal('image');
            $newImage = $campaign->image;

            if ($oldImage && $oldImage !== $newImage) {
                static::deleteStoredFile($oldImage);
            }
        });

        static::deleting(function (self $campaign): void {
            if ($campaign->image) {
                static::deleteStoredFile($campaign->image);
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
