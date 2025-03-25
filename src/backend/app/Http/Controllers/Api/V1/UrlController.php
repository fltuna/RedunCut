<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UrlResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{

    // This value is used for define user id while authentication feature is not implemented.
    const USER_ID_FOR_TEST_BEFORE_AUTH_IMPLEMENTED = 1;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'where' => 'api index',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'original_url' => 'required|url',
                'short_code' => 'nullable|alpha_dash|min:3|max:50|unique:urls,short_code'
            ]);


            $url = new Url();
            $url->original_url = $validated['original_url'];


            $url->short_code = $validated['short_code'] ?? $this->generateUniqueShortCode();

            $url->user_id = self::USER_ID_FOR_TEST_BEFORE_AUTH_IMPLEMENTED;
            $url->save();

            return response()->json([
                'id' => $url->id,
                'original_url' => $url->original_url,
                'short_code' => $url->short_code,
                'short_url' => url("/s/{$url->short_code}"),
                'created_at' => $url->created_at
            ], 201);
        } catch (ValidationException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            if(!ctype_digit($id))
                return self::return400("ID is should be integer. Provided: {$id}");


            $url = Url::find($id);

            if(!isset($url))
                return self::return404();

            return response()->json(new UrlResource($url));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $url = Url::find($id);

            if(!isset($url))
                return self::return404();


            $validated = $request->validate([
                'original_url' => 'nullable|url',
                'short_code' => 'nullable|alpha_dash'
            ]);

            $url->fill($validated);

            if($url->save())
            {
                return response()->json(new UrlResource($url));
            }
            else
            {
                return self::return500('Failed to update');
            }
        } catch (ValidationException $e){
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
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
