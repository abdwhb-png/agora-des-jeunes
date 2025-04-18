<?php

// app/Http/Middleware/CacheImages.php
namespace App\Http\Middleware;

use Closure;
use App\Enums\ConfigEnum;
use Illuminate\Http\Request;

class CacheImages
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is(ConfigEnum::GET_IMAGE_URL_PATH->value . '/*')) {
            $response->header('Cache-Control', 'public, max-age=31536000');
            $response->header('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
        }

        return $response;
    }
}