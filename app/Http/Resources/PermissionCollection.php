<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Traits\ResourceCollectionTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
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
            return  [
                ...$item->toArray(),
                'updated' => $item->updated_at->diffForHumans(),
                'created' => $item->created_at->format('d/m/Y à H:i:s')
            ];
        });

        // Return the paginated response with the transformed data
        return $this->pagination($data);
    }
}
