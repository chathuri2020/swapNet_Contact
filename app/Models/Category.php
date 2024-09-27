<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories'; // Specify the table name


    protected $fillable = [
        'category_name',
        'category_type',
        'slug',
        'reference_id',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'category_contact', 'category_id', 'contact_id');
    }

    public function subcategoriesLevelOne()
    {
        return $this->hasMany(Category::class, 'reference_id')->where('category_type', 'sub1');
    }

    public function subcategoriesLevelTwo()
    {
        return $this->hasMany(Category::class, 'reference_id')->where('category_type', 'sub2');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'reference_id');
    }

   /*  public function subcategoriesLevelOne()
    {
        return $this->hasMany(SubcategoryLevelOne::class, 'category_id');
    } */
}
