<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Account extends Model
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'balance', 'user_id'
    ];

    protected $hidden = [
        'id'
    ];

    public function getUserIdAttribute($value)
    {
        $user = User::findOrFail($value);
        return $user->name;
    }
}
