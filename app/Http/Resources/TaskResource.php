<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource->only([
            'id',
            'user_id',
            'title',
            'description',
            'deadline',
        ]);

        $data['assignee_count'] = $this->resource->assignees->count();

        return $data;
    }
}
