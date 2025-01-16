<?php

namespace App\Http\Services\Image;

use Tinify\Tinify;
use Illuminate\Support\Facades\File;
use App\Contracts\Image\ImageOptimization;

class TinifyApi implements ImageOptimization
{
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = env("TINIFY_KEY");

        Tinify::setKey($this->apiToken);
    }

    public function optimizeImage($image)
    {
        try {
            $image_name =  time() . '-' . $image->getClientOriginalName();

            $upload_temp_path = public_path('/uploads/');

            $source = $image->move($upload_temp_path, $image_name);

            $optimize = \Tinify\fromFile($source);
            $optimize->toFile($upload_temp_path . 'opt_'. $image_name);

            $resized = $optimize->resize(array(
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ));

            $upload_path = public_path('/images/users/');

            $resized->toFile($upload_path . $image_name);

            File::cleanDirectory($upload_temp_path);

            return ['success' => true, 'image' => $image_name];

        } catch(\Tinify\AccountException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        } catch(\Tinify\ClientException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        } catch(\Tinify\ServerException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        } catch(\Tinify\ConnectionException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        } catch(Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}