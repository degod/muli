<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'quantity', 'price', 'rating', 'front_img', 'rear_img', 'left_img', 'right_img'];
    protected $table = 'product';
}
