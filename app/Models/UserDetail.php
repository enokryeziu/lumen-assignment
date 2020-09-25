<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //
    protected $fillable = [
        'name',
        'date_of_birth',
        'phone',
        'address',
    ];

    protected $table = 'users_details';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
