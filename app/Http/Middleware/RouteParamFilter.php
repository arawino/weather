<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RouteParamFilter
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $config = config('route.filter');
        if (Arr::has($config, $request->route()->getName())) {
            foreach (Arr::get($config, $request->route()->getName()) as $argument) {
                $request->route()->forgetParameter($argument);
            }
        }

        return $next($request);
    }

}
