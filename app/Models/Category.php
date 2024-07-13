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
        'name',
    ];

    public function subcategoriesLevelOne()
    {
        return $this->hasMany(SubcategoryLevelOne::class, 'category_id');
    }
}
