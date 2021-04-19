<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_verfication extends Model
{
    use HasFactory;
    public $table = 'user_verfication_codes';

    protected $fillable = ['user_id', 'code','created_at','updated_at'];


    public function attribute(){
        return $this -> belongsTo(Attribute::class,'attribute_id');
    }



}
