<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'name' , 'user_id', 'description' , 'price',
        'discounted_price' , 'catagory' , 'contact' , 
        'quantity' , 'expired_date' ,'views' ,
          'image_src' , "fifty_thirty" ,
        "thirty_fifteen" , "fifteen_zero"   
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
     public function likes(){
        return $this->hasMany(Like::class);
    }   
        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
