<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterCategory extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    public function campaigns() {
        return $this->hasMany(Campaign::class, 'category_id');
    }
}
