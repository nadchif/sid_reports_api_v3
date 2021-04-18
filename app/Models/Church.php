<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\Conference;

class Church extends Model
{
    use HasFactory;    
    public function district()
    {
        return $this->belongsTo(District::class);
    }    
    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
