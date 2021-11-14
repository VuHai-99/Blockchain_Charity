<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadImageService
{
    public static function upload($file)
    {
        $driver = env('STORAGE_DRIVER', 'local');
        if (!$file) {
            return false;
        }
        $orignal_filename = time() . "_" . basename($file->getClientOriginalName());
        // $path = Storage::disk('s3')->put('images/originals',$file, 'public');
        $path = Storage::disk($driver)->putFileAs(
            'public',
            $file,
            $orignal_filename,
            'public'
        );
        return Storage::disk($driver)->url($path);
    }
}
