<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Union;

class Division extends Model
{
    use HasFactory;
    public function churches()
    {
        return $this->hasMany(Union::class);
    }
}
