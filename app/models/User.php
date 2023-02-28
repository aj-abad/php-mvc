<?php

namespace App\Models;

class User extends Model
{
  protected $fillable = [
    "id",
    "name",
    "email",
    "password",
  ];
}
