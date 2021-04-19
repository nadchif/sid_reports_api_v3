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
    public function users(){
        return $this->hasMany(User::class, 'org_id')->where('category', 'church');
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
