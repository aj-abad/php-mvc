<?php

namespace App\Models;

class Model
{
  protected $fillable = [];

  public function __construct(array $attributes = [])
  {
    $this->fill($attributes);
  }

  public function fill(array $attributes)
  {
    foreach ($attributes as $key => $value) {
      if (in_array($key, $this->fillable)) {
        $this->{$key} = $value;
      }
    }
  }
}
