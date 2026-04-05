<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterImpact extends Model
{
    protected $fillable = [
        'campaign_id', 
        'latitude', 
        'longitude', 
        'kecamatan', 
        'desa', 
        'jumlah_korban', 
        'jumlah_pengungsi', 
        'tingkat_keparahan'
    ];

    public function campaign() { 
        return $this->belongsTo(Campaign::class); 
    }
}
