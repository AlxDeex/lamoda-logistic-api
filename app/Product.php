<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['id', 'name', 'container_id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
