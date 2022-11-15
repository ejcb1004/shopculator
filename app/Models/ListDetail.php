<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDetail extends Model
{
    use HasFactory;

    protected $table = 'list_details';
    
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'is_checked',
        'list_index',
        'detail_id',
        'list_id',
        'product_id',
        'current_price',
        'image_path',
        'quantity',
        'is_deleted'
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function lists()
    {
        return $this->belongsTo(ShoppingList::class, 'list_id', 'id');
    }
}
