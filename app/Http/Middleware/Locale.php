<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class Locale
 * @package App\Http\Middleware
 */
class Locale
{

    /**
     * Header name
     * @var string
     */
    public const HEADER_NAME = 'X-Locale';

    /**
     * Default locale
     * @var string
     */
    public const DEFAULT_LOCALE = 'en';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header(self::HEADER_NAME, self::DEFAULT_LOCALE);
        app()->setLocale($locale);

        return $next($request);
    }
}
