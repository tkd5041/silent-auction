<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Axial extends Model
{
    protected $table = 'axials';

  protected $fillable = [
    'status', 'dt_nw', 'dt_st', 'st_sp'
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}
