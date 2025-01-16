<?php

namespace App\Http\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Contracts\Image\ImageOptimization;

class UserService
{
    private $imageOptimization;

    public function __construct(ImageOptimization $imageOptimization)
    {
        $this->imageOptimization = $imageOptimization;
    }

    public function setStore($data)
    {
        DB::beginTransaction();
        try {
            $image = $this->imageOptimization->optimizeImage($data['photo']);

            if (!$image['success']) {
                return response()->json(['success' => false, 'message' => $image['message']], 500);
            }
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'position_id' => $data['position_id'],
                'image' => $image['image']
            ]);

            DB::commit();

            return response()->json(['success' => true, 'user_id' => $user->id, 'message' => 'New user successfully registered.'], 201);
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode());
        }
    }
}
