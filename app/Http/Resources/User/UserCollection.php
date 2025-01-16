<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResourceCollection;

class UserCollection extends BaseResourceCollection
{
    public static $wrap = 'users';
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
}
