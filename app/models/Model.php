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

  public function toArray(bool $fillableOnly = false)
  {
    $attributes = get_object_vars($this);
    if ($fillableOnly) {
      $attributes = array_intersect_key($attributes, array_flip($this->fillable));
    }
    return $attributes;
  }
}
