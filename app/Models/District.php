<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Conference;
use \App\Models\Church;

class District extends Model
{
    use HasFactory;

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }        
    public function churches()
    {
        return $this->hasMany(Church::class);
    }
}
