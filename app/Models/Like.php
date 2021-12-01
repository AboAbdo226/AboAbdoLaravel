<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'like';
        protected $fillable = [
        'user_like'
    ];

        public function product()
{
        return $this->belongsTo(Product::class);
}
}
