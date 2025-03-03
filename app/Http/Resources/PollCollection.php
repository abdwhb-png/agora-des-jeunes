<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Traits\ResourceCollectionTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PollCollection extends ResourceCollection
{
    use ResourceCollectionTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Transform each item in the collection
        $data = $this->collection->map(function ($item) {
            return [
                ...$item->toArray(),
                'debut' => $item->start_at ? $item->start_at->format("d/m/Y à H:i:s") : null,
                'total_votes' => $item->votes()->count(),
                'fin' => $item->end_at ? $item->end_at->format("d/m/Y à H:i:s") : null,
            ];
        });

        // Return the paginated response with the transformed data
        return $this->pagination($data);
    }
}
