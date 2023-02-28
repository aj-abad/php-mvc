<?php

namespace App\Modules;

class DB
{
  public static function connect()
  {
    $config = require_once $_SERVER["DOCUMENT_ROOT"] . "/config/database.php";
    $dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']}";
    $pdo = new \PDO($dsn, $config['DB_USER'], $config['DB_PASS']);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $pdo;
  }

  public static function query($sql, $params = [])
  {
    $stmt = self::connect()->prepare($sql);
    $queryResult = $stmt->execute($params);
    if ($queryResult) {
      return $stmt->fetchAll();
    }
    return null;
  }
}
