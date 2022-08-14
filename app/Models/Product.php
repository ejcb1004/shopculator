<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'market_id',
        'category_id',
        'product_name',
        'image_path',
        'price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
