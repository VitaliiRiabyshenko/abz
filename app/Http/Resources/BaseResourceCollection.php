<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    public function with($request)
    {
        return [
            "success" => true,
        ];
    }

    public function paginationInformation($request)
    {
        $paginated = $this->resource->toArray();

        $total = $this->resource->isNotEmpty() ? 'total_'.$this->resource->first()->getTable() : 'total';

        return [
            'page' => $paginated['current_page'],
            'total_pages' => $paginated['last_page'],
            $total => $paginated['total'],
            'count' => $paginated['per_page'],
            'links' => [
                'next_url' => $paginated['next_page_url'],
                'prev_url' => $paginated['prev_page_url']
            ]
        ];
    }
}
