<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'short_code' => $this->short_code,
            'short_url' => url("/s/{$this->short_code}"),
            'expires_at' => $this->expires_at,
            'clicks' => $this->clicks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
