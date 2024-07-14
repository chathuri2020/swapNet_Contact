<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'address',
        'email',
        'company_name',
        'company_registration_number',
    ];

    public function subcategoryLevelTwo()
    {
        return $this->belongsToMany(SubcategoryLevelTwo::class, 'category_contact');
    }
}
