<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loginfo extends Model
{
    use HasFactory;
    function rel_to_user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
