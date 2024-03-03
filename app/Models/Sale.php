<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = [
        'status',
        'total_products',
        'price'
    ];

    protected $casts = [
        'price' => 'int'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_products')->withPivot('amount');
    }
}
