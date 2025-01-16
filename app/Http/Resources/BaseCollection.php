<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    public function with($request)
    {
        return [
            "success" => true,
        ];
    }
}
