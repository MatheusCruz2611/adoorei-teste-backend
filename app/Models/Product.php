<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'description'
    ];
    protected $casts = [
        'active' => 'boolean',
        'price' => 'int'
    ];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_products')->withPivot('amount');
    }
}
