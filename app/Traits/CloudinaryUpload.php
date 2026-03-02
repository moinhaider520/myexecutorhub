<?php

namespace App\Traits;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait CloudinaryUpload
{
    public function uploadToCloud($file, $folder = 'executorhub')
    {
        $result = Cloudinary::upload(
            $file->getRealPath(),
            [
                'folder' => $folder,
                'transformation' => [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'fill'
                ]
            ]
        );

        return [
            'url' => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ];
    }

    public function deleteFromCloud($publicId)
    {
        if ($publicId) {
            Cloudinary::destroy($publicId);
        }
    }
}
