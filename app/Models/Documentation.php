<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Campaign;

class Documentation extends Model
{

public function index()
{
    $documentations = Documentation::with('campaign.user')
        ->latest()
        ->take(3) // tampil 3 saja di landing
        ->get();

    return view('pages.home.index', compact('documentations'));
}

protected static function booted()
{
    static::creating(function ($doc) {

        if (empty($doc->slug)) {

            $campaign = \App\Models\Campaign::find($doc->campaign_id);

            if (!$campaign) return;

            $baseSlug = Str::slug($campaign->title);

            $slug = $baseSlug;
            $count = 1;

            while (self::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $doc->slug = $slug;
        }
    });
}

    protected $fillable = [
        'campaign_id', 
        'tgl_penyerahan', 
        'nama_penerima', 
        'deskripsi',    
        'bukti_foto',
        'attachment',
    ];

    public function campaign() { 
        return $this->belongsTo(Campaign::class); 
    }
    protected $casts = [
    'tgl_penyerahan' => 'date',
];
}
