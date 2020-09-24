<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
  protected $table = "donors";

  public function items()
  {
    return $this->hasMany(Item::class);
  }
}
