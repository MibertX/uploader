<?php
namespace App\Services;
use App\Contracts\ImageUploader;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SimpleImageUploader implements ImageUploader
{
	protected $failedUploads = array();
	
	public function upload(array $images, $dir, $image_width = 640, $thumbnail_width = 200)
	{
		if (!$dir) return false;
		$dir = str_replace('.', DIRECTORY_SEPARATOR, $dir);
		$dir = trim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		Storage::disk('public')->makeDirectory($dir . 'thumbs');
		$uploadedImages = [];

		foreach ($images as $originalImage) {
			$imageOriginalName = $originalImage->getClientOriginalName();

			if (strpos($originalImage->getMimeType(), 'image/') !== 0) {
				$this->failedUploads[] = $imageOriginalName;
				continue;
			}
			
			$imageNewName = date('Ymd_His_') . uniqid(true) . '.'
				. $originalImage->getClientOriginalExtension();
			
			$imgPublicPath = $dir . $imageNewName;
			
			try {
				Storage::putFileAs($dir, $originalImage, $imageNewName);
				
				Storage::disk('public')->put(
					$imgPublicPath,
					Image::make($originalImage)->widen($image_width)->encode()
				);

				Storage::disk('public')->put(
					$dir . 'thumbs' . DIRECTORY_SEPARATOR . $imageNewName,
					Image::make($originalImage)->widen($thumbnail_width)->encode()
				);

				$uploadedImages[$imgPublicPath] = $imageOriginalName;
			} catch (\Exception $exception) {
				$this->failedUploads[] = $imageOriginalName;
				continue;
			}
		}
		
		return $uploadedImages;
	}

	public function getLastFailedUploads()
	{
		return $this->failedUploads;
	}
}
