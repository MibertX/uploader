<?php
namespace App\Contracts;

interface ImageUploader
{
	public function upload(array $images, $dir, $big_image_size, $thumb_size);
	public function getLastFailedUploads();
}