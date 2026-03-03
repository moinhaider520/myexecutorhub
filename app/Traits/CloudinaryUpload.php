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

    public function uploadFileToCloud($file, $folder = 'executorhub')
    {
        $result = Cloudinary::upload(
            $file->getRealPath(),
            [
                'folder' => $folder,
                'resource_type' => 'auto',
            ]
        );

        return [
            'url' => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ];
    }

    public function deleteFromCloud($publicId)
    {
        if (!$publicId) {
            return true;
        }

        foreach (['image', 'video', 'raw'] as $resourceType) {
            $result = Cloudinary::destroy($publicId, [
                'resource_type' => $resourceType,
            ]);

            if (($result['result'] ?? null) === 'ok') {
                return true;
            }
        }

        return false;
    }
}
