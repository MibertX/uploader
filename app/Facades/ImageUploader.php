<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;
use App\Contracts\ImageUploader as ImageUploaderContract;

class ImageUploader extends Facade
{
	protected static function getFacadeAccessor()
	{
		return ImageUploaderContract::class;
	}
}