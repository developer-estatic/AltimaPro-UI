<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!isAdmin()) {
            // dd($user->businessUnit()->first()->brand);
            $brand = $user->businessUnit()->whereStatus(1)->first()->brand()->whereStatus(1)->first(); // Fetch the user's brand

            $role = $user->roles()->first(); // Fetch the user's role

            if ($role) {
                $routeName = $request->route()->getName(); // Get the current route name

                // Check if the role has permission for this route and brand
                // \DB::enableQueryLog(); // Enable query log for debugging
                $hasPermission = $role->permissions()
                    ->where('name', $routeName) // Match the route name
                    ->wherePivot('brand_id', $brand->id) // Match the brand ID in the pivot table
                    ->exists();

                    if(!$hasPermission) {
                        $hasPermission = $user->permissions()
                            ->where('name', $routeName) // Match the route name
                            ->wherePivot('brand_id', $brand->id) // Match the brand ID in the pivot table
                            ->exists();
                    }


                // dd(\DB::getQueryLog()); // Uncomment to see the executed query log

                if (!$hasPermission) {
                    abort(403, 'Unauthorized'); // Abort if the user does not have permission
                }
            }
        }
        return $next($request);
    }
}
