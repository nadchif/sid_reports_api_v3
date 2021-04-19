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
    public function users(){
        return $this->hasMany(User::class, 'org_id')->where('category', 'district');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'v2id',
        'updated_at',
        'created_at',
        'division_id',
    ];
}
