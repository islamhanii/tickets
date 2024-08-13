<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageStorage
{
    private function uploadImage($request, $folder, $record = null, $uploadedImageName = 'image', $recordImageName = 'image')
    {
        if (!$record) {
            if (!$request->hasFile($uploadedImageName)) return null;
            return Storage::putFile($folder, $request->file($uploadedImageName));
        }

        $path = $record->$recordImageName;
        if (!$request->hasFile($uploadedImageName)) return (!$path) ? null : $path;

        if ($path)   $this->deleteImage($path);
        return Storage::putFile($folder, $request->file($uploadedImageName));
    }

    private function uploadMultipleImages($request, $folder)
    {
        $paths = [];
        if ($request->images) {
            foreach ($request->file('images') as $image) {
                $path = Storage::putFile($folder, $image);
                array_push($paths, $path);
            }
        }

        return $paths;
    }

    private function deleteImage($path)
    {
        if ($path) {
            $image = $path;
            Storage::delete($image);
        }
    }
}
