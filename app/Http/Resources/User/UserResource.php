<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
    public static $wrap = 'user';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position?->name,
            'position_id' => $this->position_id,
            'image' => public_path($this->image),
        ];
    }

    public function with($request)
    {
        return [
            "success" => true,
        ];
    }
}
