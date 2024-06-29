<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function userNumbers(){
        return $this->hasMany(UserNumber::class, 'number_id');
    }

    public function callRecords(){
        return $this->hasMany(CallRecord::class, 'number_id');
    }
}
