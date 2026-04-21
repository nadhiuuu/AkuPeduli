<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;

class Documentation extends Model
{
    protected $fillable = [
        'campaign_id', 
        'tgl_penyerahan', 
        'nama_penerima', 
        'deskripsi', 
        'bukti_foto'
    ];

    public function campaign() { 
        return $this->belongsTo(Campaign::class); 
    }
    protected $casts = [
    'tgl_penyerahan' => 'date',
];
}
