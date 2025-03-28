<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UrlResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $urls = Url::where('user_id', $request->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);

        return response()->json($urls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try{
            $validated = $request->validate([
                'original_url' => 'required|url',
                'short_code' => 'nullable|alpha_dash|min:3|max:50|unique:urls,short_code'
            ]);


            $url = new Url();
            $url->original_url = $validated['original_url'];


            $url->short_code = $validated['short_code'] ?? $this->generateUniqueShortCode();

            $url->user_id = $request->user()->id;
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
    public function show(Request $request, string $url_id): JsonResponse
    {
        try {
            $url = Url::where('user_id', $request->user()->id)
                        ->where('id', $url_id)->first();

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
    public function update(Request $request, string $url_id): JsonResponse
    {
        try{
            $url = Url::where('user_id', $request->user()->id)
                        ->where('id', $url_id)->first();

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
    public function destroy(Request $request, string $url_id): JsonResponse
    {
        try{
            $url = Url::where('user_id', $request->user()->id)
                        ->where('id', $url_id)->first();

            if(!isset($url))
                return self::return404();

            if($url->delete())
            {
                return response()->json([
                    'message' => 'Resource Deleted',
                ]);
            }
            else
            {
                return self::return500('Failed to update');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
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
