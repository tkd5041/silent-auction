<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = "images";
    protected $guarded = [];

    public function item()
    {
        return $this->belongsToMany(Item::class);
    }
}
