<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    

    public function scopeSearch($query,$term){
        $term = "%$term%";
        $query->where(function($query) use ($term){
            $query->where('product_name','like',$term);
        });
    }
}
