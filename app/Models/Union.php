<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
    public function districts()
    {
        return $this->hasManyThrough(District::class, Conference::class);
    } 
    public function churches()
    {
        return $this->hasManyThrough(Church::class, Conference::class);
    } 
    public function users(){
        return $this->hasMany(User::class, 'org_id')->where('category', 'union');
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
