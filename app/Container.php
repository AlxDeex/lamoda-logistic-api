<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    public $incrementing = false;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['id', 'name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
