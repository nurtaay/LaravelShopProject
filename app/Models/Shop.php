<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Manufacturer;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'size', 'description', 'image', 'manufacturer_id', 'category_id', 'user_id'];


    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userCart(){
        return $this->belongsToMany(User::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
