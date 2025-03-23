<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class UrlController extends Controller
{

    // This value is used for define user id while authentication feature is not implemented.
    const USER_ID_FOR_TEST_BEFORE_AUTH_IMPLEMENTED = 1;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'original_url' => 'required|url',
                'custom_alias' => 'nullable|alpha_dash'
            ]);


            $url = new Url();
            $url->original_url = $validated['original_url'];


            if(!empty($validated['custom_alias']))
            {
                $url->short_code = $validated['custom_alias'];
            }
            else
            {
                $url->short_code = $this->generateUniqueShortCode();
            }

            $url->user_id = self::USER_ID_FOR_TEST_BEFORE_AUTH_IMPLEMENTED;
            $url->save();

            return response()->json([
                'id' => $url->id,
                'original_url' => $url->original_url,
                'short_code' => $url->short_code,
                'short_url' => url("/s/{$url->short_code}"),
                'created_at' => $url->created_at
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([]);
    }


    /**
     * Generates a unique short code for custom_alias
     */
    private function generateUniqueShortCode($length = 6) : string
    {
        do {
            $shortCode = Str::random($length);
        } while (Url::withTrashed()->where('short_code', $shortCode)->exists());

        return $shortCode;
    }
}
