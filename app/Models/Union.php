<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Division;

class Union extends Model
{
    use HasFactory;
    
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function conferences()
    {
        return $this->hasMany(Conference::class);
    }    

}
