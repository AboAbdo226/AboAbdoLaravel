<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
        protected $fillable = [
        'user_name' , 'comment' , 'product_id'
    ];
    public function product()
{
        return $this->belongsTo(Product::class);
}
}
