<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryLevelOne extends Model
{
    use HasFactory;
    protected $table = 'sub_categories_l_one'; // Specify the table name
    protected $fillable = [
        'name',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategoriesLevelTwo()
    {
        return $this->hasMany(SubcategoryLevelTwo::class);
    }
}
