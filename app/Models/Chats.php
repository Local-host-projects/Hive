<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chats extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'thread'
    ];
    public function User(){
        return $this->belongsTo(User::class,'user');
    }
}
