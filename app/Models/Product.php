<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopeSearch($query,$term){
        $term = "%term%";
        $query->where(function($query) use ($term){
            $query->where('product_name','like',$term);
        });
    }
}
