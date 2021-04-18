<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Church;
use App\Models\Union;

class Conference extends Model
{
    use HasFactory;
    public function union()
    {
        return $this->belongsTo(Union::class);
    }
        
    public function churches()
    {
        return $this->hasMany(Church::class);
    }
}
