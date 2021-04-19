<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
    public function districts()
    {
        return $this->hasMany(District::class);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'org_id')->where('category', 'conference');
    }
    public function allUsers(){
        $all_users = new Collection();               
        $all_users = $all_users->merge($this->district_users);              
        $all_users = $all_users->merge($this->church_users);
        $all_users = $all_users->pluck('users')->flatten();
        $all_users = $all_users->merge($this->users);
        return($all_users);
    }
    public function district_users()
    {
        return $this->districts()->with('users');
    }
    public function church_users()
    {
        return $this->churches()->with('users');
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
