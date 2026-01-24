<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    // Puedes poner '*' si quieres confiar en todos los proxies (útil en desarrollo)
    protected $proxies = '*';

    // Aquí definimos qué headers usar, con la constante CORRECTA
    protected $headers = Request::HEADER_X_FORWARDED_FOR | 
                         Request::HEADER_X_FORWARDED_HOST | 
                         Request::HEADER_X_FORWARDED_PORT | 
                         Request::HEADER_X_FORWARDED_PROTO;
}
