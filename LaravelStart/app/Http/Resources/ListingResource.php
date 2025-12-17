<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'price' => (float) $this->price,
            'currency' => $this->currency,
            'is_active' => $this->is_active,
            'service_type' => [
                'id' => $this->serviceType->id ?? null,
                'name' => $this->serviceType->name ?? null,
                'slug' => $this->serviceType->slug ?? null,
            ],
            'supplier' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? null,
                'email' => $this->user->email ?? null,
                'contact_number' => $this->user->contact_number ?? null,
            ],
            'tags' => $this->tags->pluck('name')->all(),
            'images' => $this->images->map(function($img){ return ['path'=>$img->path, 'alt'=>$img->alt]; })->all(),
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
