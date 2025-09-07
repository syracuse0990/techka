<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ImageService
{
    public function processLogo($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $match)) {

            $base64File = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageData = base64_decode($base64File);
            $extension = $match[1];
            $uniqueId = time() . '-' . Str::uuid();
            $logoName = $uniqueId . '-company_logo.' . $extension;


            $image = Image::read($imageData);

            $this->saveImage($image, $logoName, 'logo/100x100/', 100, 100);

            $this->saveImage($image, $logoName, 'logo/500x500/', 500, 500);

            $this->saveImage($image, $logoName, 'logo/250x150/', 250, 150);

            return $logoName;
        }

        return null;
    }

    public function processAvatar($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $match)) {

            $base64File = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageData = base64_decode($base64File);
            $extension = $match[1];
            $avatarName = Str::uuid(). '-avatar.' . $extension;

            $image = Image::read($imageData);

            $this->saveImage($image, $avatarName, 'avatars/', 100, 100);

            return $avatarName;
        }

        return null;
    }

    protected function saveImage($image, $logoName, $directory, $width, $height)
    {
        $path = public_path($directory . $logoName);
        $image->resize($width, $height)->save($path);
    }
}
