<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'prep_time',
        'cook_time',
        'image_url',
    ];

    // relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function ingredient()
    {
        return $this->hasMany(Ingredient::class);
    }
    
    public function instruction()
    {
        return $this->hasMany(Instruction::class);
    }

    // pivot table relation
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category');
    }
}
