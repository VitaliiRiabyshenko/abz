<?php

namespace App\Http\Resources\Token;

use App\Http\Resources\BaseResource;

class TokenResource extends BaseResource
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
