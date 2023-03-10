<?php

namespace App\Modules;

// taken from https://gist.github.com/scokmen/f813c904ef79022e84ab2409574d1b45
enum HttpStatusCode: int
{
  case CONTINUE = 100;
  case SWITCHING_PROTOCOLS = 101;
  case PROCESSING = 102;

  case OK = 200;
  case CREATED = 201;
  case ACCEPTED = 202;
  case NON_AUTHORITATIVE_INFORMATION = 203;
  case NO_CONTENT = 204;
  case RESET_CONTENT = 205;
  case PARTIAL_CONTENT = 206;
  case MULTI_STATUS = 207;
  case ALREADY_REPORTED = 208;
  case IM_USED = 226;

  case MULTIPLE_CHOICES = 300;
  case MOVED_PERMANENTLY = 301;
  case FOUND = 302;
  case SEE_OTHER = 303;
  case NOT_MODIFIED = 304;
  case USE_PROXY = 305;
  case SWITCH_PROXY = 306;
  case TEMPORARY_REDIRECT = 307;
  case PERMANENT_REDIRECT = 308;

  case BAD_REQUEST = 400;
  case UNAUTHORIZED = 401;
  case PAYMENT_REQUIRED = 402;
  case FORBIDDEN = 403;
  case NOT_FOUND = 404;
  case METHOD_NOT_ALLOWED = 405;
  case NOT_ACCEPTABLE = 406;
  case PROXY_AUTHENTICATION_REQUIRED = 407;
  case REQUEST_TIMEOUT = 408;
  case CONFLICT = 409;
  case GONE = 410;
  case LENGTH_REQUIRED = 411;
  case PRECONDITION_FAILED = 412;
  case PAYLOAD_TOO_LARGE = 413;
  case URI_TOO_LONG = 414;
  case UNSUPPORTED_MEDIA_TYPE = 415;
  case RANGE_NOT_SATISFIABLE = 416;
  case EXPECTATION_FAILED = 417;
  case I_AM_A_TEAPOT = 418;
  case MISDIRECTED_REQUEST = 421;
  case UNPROCESSABLE_ENTITY = 422;
  case LOCKED = 423;
  case FAILED_DEPENDENCY = 424;
  case UPGRADE_REQUIRED = 426;
  case PRECONDITION_REQUIRED = 428;
  case TOO_MANY_REQUESTS = 429;
  case REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
  case UNAVAILABLE_FOR_LEGAL_REASONS = 451;

  case INTERNAL_SERVER_ERROR = 500;
  case NOT_IMPLEMENTED = 501;
  case BAD_GATEWAY = 502;
  case SERVICE_UNAVAILABLE = 503;
}

class RedirectResponse
{
  public string $route;
  public function __construct(string $route)
  {
    $this->route = $route;
  }
}

class Response
{
  public static function status(HttpStatusCode $code)
  {
    http_response_code($code->value);
  }

  public static function header($key, $value, $replace = true)
  {
    header("$key: $value", $replace);
  }

  public static function cookie($key, $value, $expire = 0, $path = "/", $domain = "", $secure = false, $httponly = false)
  {
    setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);
  }

  public static function redirect(string $route): RedirectResponse
  {
    self::status(HttpStatusCode::SEE_OTHER);
    self::header("Location", $route);
    return new RedirectResponse($route);
  }
}
