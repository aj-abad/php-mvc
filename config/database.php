<?php

return [
  "DB_HOST" => getenv("DB_HOST") ?? "localhost",
  "DB_NAME" => getenv("DB_NAME") ?? "lifescan",
  "DB_USER" => getenv("DB_USER") ?? "root",
  "DB_PASS" => getenv("DB_PASS") ?? "",
];
