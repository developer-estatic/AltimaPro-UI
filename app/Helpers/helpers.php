<?php

use App\Models\User;
use App\Lib\ClientInfo;
use App\Models\Country;
use App\Lib\FileManager;
use App\Models\CrmMetaData;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;


if (!function_exists('getIpInfo')) {
    function getIpInfo()
    {
        $ipInfo = ClientInfo::ipInfo();
        return $ipInfo;
    }
}

if (!function_exists('osBrowser')) {
    function osBrowser()
    {
        $osBrowser = ClientInfo::osBrowser();
        return $osBrowser;
    }
}

if (!function_exists('getRealIP')) {
    function getRealIP()
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        //Deep detect ip
        if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }
        if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }
}

if (!function_exists('fileUploader')) {
    function fileUploader($file, $location, $size = null, $old = null, $thumb = null)
    {
        $fileManager = new FileManager($file);
        $fileManager->path = $location;
        $fileManager->size = $size;
        $fileManager->old = $old;
        $fileManager->thumb = $thumb;
        $fileManager->upload();
        return $fileManager->filename;
    }
}

if (!function_exists('fileManager')) {
    function fileManager()
    {
        return new FileManager();
    }
}

if (!function_exists('getFilePath')) {
    function getFilePath($key)
    {
        return fileManager()->$key()->path;
    }
}

if (!function_exists('getFileSize')) {
    function getFileSize($key)
    {
        return fileManager()->$key()->size;
    }
}

if (!function_exists('getFileExt')) {
    function getFileExt($key)
    {
        return fileManager()->$key()->extensions;
    }
}

if (!function_exists('getImage')) {
    function getImage($image, $size = null)
    {
        $clean = '';
        if (file_exists($image) && is_file($image)) {
            return asset($image) . $clean;
        }
        //        if ($size) {
        //            return placeholderImage($size);
        //        }
        return asset('assets/images/default.png');
    }
}

if (!function_exists('placeholderImage')) {
    function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/fonts/RobotoMono-Regular.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $manager = new ImageManager(Driver::class);
        $image = $manager->create($imgWidth, $imgHeight)->fill('ccc');
        print_r($image);
        exit();
        //        return $image;
    }
}

if (!function_exists('format_label')) {
    /**
     * @param $label
     * @return string
     */
    function format_label($label): string
    {
        return ucwords(str_replace('-', ' ', $label));
    }
}

if (!function_exists('log_incident')) {
    function log_incident($e, $request = null): string
    {
        if ($request)
            $incidentID = $request['incident_id'];
        else
            $incidentID = request()->get('incident_id');

        Log::error('Incident ID: ' . $incidentID . ' - ' . $e->getMessage() . '. ' . $e->getFile() . ':' . $e->getLine() . json_encode($e->getTrace()));
        return $incidentID;
    }
}

if (!function_exists('get_permissions')) {
    function get_permissions()
    {
        return auth()->user()->getAllPermissions();
    }
}
if (!function_exists('makeInitials')) {
    function makeInitials($param, $separator = ' ')
    {
        $name = explode($separator, $param);
        $initials = strtoupper(substr($name[0], 0, 1));
        if (count($name) > 1) {
            $initials .= strtoupper(substr($name[count($name) - 1], 0, 1));
        }
        return $initials;
    }
}

if (!function_exists('getStatusTextIconAttribute')) {
    function getStatusTextIconAttribute($status)
    {
        return $status ? 'icon-[fa-regular--check-circle]' : 'icon-[fa-regular--times-circle]';
    }
}
if (!function_exists('getStatusClassAttribute')) {
    function getStatusClassAttribute($status)
    {
        return $status ? 'text-green-700!' : 'text-red-700!';
    }
}
if (!function_exists('getTypesFromCRMMetaData')) {
    function getTypesFromCRMMetaData($type)
    {
        return CrmMetaData::where('type', $type)->where('status', 1)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => Str::ucfirst(Str::replace('_', ' ', $item->name, false)),
            ];
        });
    }
}
if (!function_exists('getNameFromMetaData')) {
    function getNameFromMetaData($id)
    {
        return CrmMetaData::find($id)?->name;
    }
}
if (!function_exists('getCountryNames')) {
    function getCountryNames($array)
    {
        return implode(', ', Country::whereIn('id', $array)->pluck('name')->toArray());
    }
}

if (!function_exists('currentUserHasRoleId')) {
    function currentUserHasRoleId($roleId = 1): int
    {
        $user = Auth::user();
        return $user && $user->hasRoleId($roleId) ? 1 : 0;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin($id = null): bool
    {
        if ($id) {
            $user = User::find($id);
        } else {
            $user = Auth::user();
        }
        if (!$user) {
            return false;
        }
        if ($user->hasRoleId(1)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission($routeName)
    {
        try {
            $user = Auth::user();
            if (!isAdmin()) {
                $brand = $user->businessUnit()->whereStatus(1)->first()->brand()->whereStatus(1)->first(); // Fetch the user's brand
                $role = $user->roles()->first(); // Fetch the user's role

                if ($role) {
                    // $routeName = request()->route()->getName(); // Get the current route name

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
                        return false; // Abort if the user does not have permission
                    } else {
                        return true; // User has permission
                    }
                }
                return false; // Abort if the user does not have permission
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

if (!function_exists('canPerformAction')) {
    function canPerformAction($action)
    {
        try {
            $user = Auth::user();
            if (!isAdmin()) {
                $brand = $user->businessUnit()->whereStatus(1)->first()->brand()->whereStatus(1)->first(); // Fetch the user's brand
                $role = $user->roles()->first(); // Fetch the user's role

                if ($role) {
                    // $routeName = request()->route()->getName(); // Get the current route name

                    // Check if the role has permission for this route and brand
                    // \DB::enableQueryLog(); // Enable query log for debugging
                    $hasPermission = $role->permissions()
                        ->where('name', $action) // Match the route name
                        ->wherePivot('brand_id', $brand->id) // Match the brand ID in the pivot table
                        ->exists();
                    // dd(\DB::getQueryLog()); // Uncomment to see the executed query log

                    if(!$hasPermission) {
                        $hasPermission = $user->permissions()
                            ->where('name', $action) // Match the route name
                            ->wherePivot('brand_id', $brand->id) // Match the brand ID in the pivot table
                            ->exists();
                    }

                    if (!$hasPermission) {
                        return false; // Abort if the user does not have permission
                    } else {
                        return true; // User has permission
                    }
                }
                return false; // Abort if the user does not have permission
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
