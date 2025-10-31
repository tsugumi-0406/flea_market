<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'post_code', 'address', 'building', 'image'];

    public function items()
{
    return $this->hasMany(Item::class);
}
}
