<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $table = 'items';

  protected $fillable = [
    'title', 'description', 'value', 'retail_value', 'initial_bid', 'increment'
];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }

  public function donor()
  {
    return $this->belongsTo(Donor::class);
  }

  public function images()
  {
    return $this->hasMany(Image::class);
  }
}
