<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
   protected $fillable = [
      'name', 'start_date', 'start_time', 'end_date', 'end_time',
  ];

  protected $table='events';

  public function items()
  {
     return $this->hasMany(Item::class);
  }

  public function donors()
  {
     return $this->hasMany(Donor::class);
  }

  public function auctions()
  {
     return $this->hasMany(Auction::class);
  }
}
