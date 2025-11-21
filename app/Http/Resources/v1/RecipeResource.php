<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => ucfirst($this->title),
            'description' => $this->description,
            'prep_time' => $this->prep_time,
            'cook_time' => $this->cook_time,
            'difficulty' => $this->difficulty,
            'image_url' => $this->image_url,

            // relations
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
