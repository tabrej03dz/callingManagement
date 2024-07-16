<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoRecord extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function number(){
        return $this->belongsTo(Number::class, 'number_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demo(){
        return $this->belongsTo(Demo::class, 'demo_id');
    }
}
