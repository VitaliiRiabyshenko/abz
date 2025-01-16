<?php

namespace App\Http\Resources\Position;

use App\Http\Resources\BaseCollection;

class PositionCollection extends BaseCollection
{
    public static $wrap = 'positions';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            "success" => true,
        ];
    }
}
