<?php

namespace App\Http\Resources;

use App\Traits\ResourceCollectionTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AgoraSessionCollection extends ResourceCollection
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
                'id' => $item->id,
                'participants' => $item->applications->count() . ' sur ' . $item->places,
                'formated_date' => $item->date->format("d/m/Y"),
            ];
        });

        // Return the paginated response with the transformed data
        return $this->pagination($data);
    }
}
