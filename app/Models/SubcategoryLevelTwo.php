<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryLevelTwo extends Model
{
    use HasFactory;
    protected $table = 'sub_categories_l_two'; // Specify the table name
    protected $fillable = [
        'name',
        'category_l_one_id',
    ];

/*     public function subcategoryLevelOne()
    {
        return $this->belongsTo(SubcategoryLevelOne::class, 'category_l_one_id');
    } */

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'category_contact');
    }
}
