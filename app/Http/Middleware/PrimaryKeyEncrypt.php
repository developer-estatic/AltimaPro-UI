<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class PrimaryKeyEncrypt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $param = null): Response
    {
        try {

            // Check if the parameter exists in the route and decrypt it
            if ($request->route($param)) {

                $route = $request->route();
                $definedRoutes = ['roles.edit', 'roles.destroy', 'users.update'];

                if(in_array($route->getName(), $definedRoutes)){
                    $parameterName = $route->parameterNames()[0];
                    $parameterValue = $route->parameters[$parameterName];
                    $parameterDecrypted = Crypt::decrypt($parameterValue);
                    $route->setParameter($parameterName, $parameterDecrypted);
                }
            }
        } catch (DecryptException $e) {
            return abort(404, 'Invalid ID');
        }

        return $next($request);
    }
}
