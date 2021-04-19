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
    public function users()
    {
        return $this->hasMany(User::class, 'org_id')->where('category', 'conference');
    }
    public function allUsers()
    {
        return $this->hasMany(User::class, 'org_id')->with('users');
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
