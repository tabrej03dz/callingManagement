<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNumber extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function number(){
        return $this->belongsTo(Number::class, 'number_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
