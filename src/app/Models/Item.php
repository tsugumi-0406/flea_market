<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'condition', 'name', 'brand', 'description', 'price'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function comments(){
            return $this->hasmany('App\Models\Comment');
    }
}
