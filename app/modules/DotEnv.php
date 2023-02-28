<?php

namespace App\Modules;

class DotEnv
{
  public static function load()
  {
    $path = "{$_SERVER['DOCUMENT_ROOT']}/.env";
    if (!file_exists($path)) {
      throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $path));
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
      if (strpos(trim($line), '#') === 0) {
        continue;
      }

      list($name, $value) = explode('=', $line, 2);
      $name = trim($name);
      $value = trim($value);

      if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
      }
    }
  }
}
