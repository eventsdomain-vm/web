<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;

trait MediaUploadable
{
    /**
     * Upload media files (logo, cover_image, banner_image) to an event model.
     */
    protected function uploadMediaFiles(HasMedia $model, Request $request): void
    {
        $mediaFields = ['logo', 'cover_image', 'banner_image'];

        foreach ($mediaFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $model->clearMediaCollection($field);
                $model->addMedia($request->file($field))
                    ->withCustomProperties(['usage' => $field])
                    ->toMediaCollection($field);
            }
        }
    }

    /**
     * Remove all media collections from a model.
     */
    protected function clearAllMediaFiles(HasMedia $model): void
    {
        foreach (['logo', 'cover_image', 'banner_image'] as $collection) {
            $model->clearMediaCollection($collection);
        }
    }
}
