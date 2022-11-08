<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $guarded = ["created_at","updated_at"] ;
    public function setValidTillAttribute($value)
    {
        $this->attributes['valid_till'] =  Carbon::parse($value);
    }
    public function user(){
        return $this->belongsTo(User::class) ;
    }
}
