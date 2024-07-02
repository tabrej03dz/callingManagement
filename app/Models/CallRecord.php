<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRecord extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function number(){
        return $this->belongsTo(Number::class, 'number_id');
    }
}
