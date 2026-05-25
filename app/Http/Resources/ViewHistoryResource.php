<?php

namespace App\Http\Resources;

use App\Models\ViewHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentItem = $this->resource;
        return [
            'id' => $currentItem->id,
            'item_id' => $currentItem->item_id,
            'created_at' => $currentItem->created_at->toIso8601String(),
            'updated_at' => $currentItem->updated_at?->toIso8601String(),
        ];
    }
}
