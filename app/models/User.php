<?php

namespace App\Models;

class User extends Model
{
  public $id;
  public $name;
  public $email;
  public $password;

  protected $fillable = [
    "id",
    "name",
    "email",
    "password",
  ];
}
