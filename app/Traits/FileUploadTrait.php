<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FileUploadTrait
{
    // Handle Upload Files
    function uploadFile(Request $request, string $inputname, ?string $oldPath = null, string $path = '/uploads'): string
    {
        if ($request->hasFile($inputname)) {
            $file = $request->{$inputname};
            $ext = $file->getClientOriginalExtension();
            $fileName = 'media_' . uniqId() . '.' . $ext;

            $file->move(public_path($path), $fileName);

            return $path . '/' . $fileName;
        }
        return '';
    }
}
