<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseCollection;

class TokenResource extends BaseCollection
{
    public static $wrap = 'token';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token' => $this->token
        ];
    }

    public function with($request)
    {
        return [
            "success" => true,
        ];
    }
}
