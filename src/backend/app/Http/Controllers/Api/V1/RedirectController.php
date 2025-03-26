<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Url;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RedirectController extends Controller
{

    public function getRedirectInfo(string $shortCode): JsonResponse
    {
        $url = Url::where('short_code', $shortCode)->first();

        if (!$url)
            return self::return404('Specified resource is not found');


        if ($url->expires_at && now()->isAfter($url->expires_at)) {
            return self::return410('Specified resource is expired');
        }

        dispatch(function () use ($url) {
            $url->increment('clicks');
        })->afterResponse();

        return response()->json([
            'original_url' => $url->original_url
        ]);
    }
}
