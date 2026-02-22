<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journals extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user',
        'condition',
        'story'
    ];
    public function User(){
        return $this->belongsTo(User::class,'user');
    }
}
