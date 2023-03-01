<?php

namespace App\Modules;

class DB
{
  public static function connect()
  {
    $config = require $_SERVER["DOCUMENT_ROOT"] . "/config/database.php";
    $dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']}";
    $pdo = new \PDO($dsn, $config['DB_USER'], $config['DB_PASS']);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $pdo;
  }

  public static function query($sql, $params = [])
  {
    $stmt = self::connect()->prepare($sql);
    // get parameters in sql query
    $stmtParams = [];
    preg_match_all("/:(\w+)/", $sql, $stmtParams);
    $stmtParams = @$stmtParams[1] ?: [];
    $neededParams = [];
    foreach ($stmtParams as $param) {
      if (isset($params[$param])) {
        $neededParams[$param] = $params[$param];
      }
    }

    $queryResult = $stmt->execute($neededParams);
    if ($queryResult) {
      return $stmt->fetchAll();
    }
    return null;
  }
}
