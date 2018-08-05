<?php
namespace App\Http\Controllers;
use App\Image;
use Illuminate\Http\Request;
use App\Facades\ImageUploader;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
	protected $maxUploadsAllowed = 10;
	
	public function uploadImage(Request $request)
	{
		if (!$request->ajax()) return response(404);

		if (!$request->images) {
			return response()->json(['message' => 'No images were uploaded'], 500);
		}
		
		if (count($request->images) > $this->maxUploadsAllowed) {
			return response()->json([
				'message' => 'Maximum uploads per once:' . $this->maxUploadsAllowed
			], 500);
		}

		$uploadedImages = ImageUploader::upload($request->images, 'images');
		$failedUploads = ImageUploader::getLastFailedUploads();
		foreach ($uploadedImages as $path => $originalName) {
			$image = new Image();
			$image->original_name = $originalName;
			$image->path = $path;

			if (!$image->save()) {
				self::deleteImageFiles($path);
				$failedUploads[] = $originalName;
				unset($uploadedImages[$path]);
			}
		}

		return response()->json([
			'uploadedImages' => $uploadedImages,
			'failedUploads' => $failedUploads
		], 200);
	}
	
	
	public function uploadedImages() 
	{
		return view('uploaded_images', array('images' => Image::all()));
	}


	public function deleteImage(Request $request, $id)
	{
		if (!$request->ajax()) return response(404);

		$image = Image::find($id);
		if ($image) {
			self::deleteImageFiles($image->path);
			$image->delete();
			return response()->json(null, 200);
		}

		return response()->json(['message' => 'Image with ID=' . $id . ' not exist'], 500);
	}

	
	protected static function deleteImageFiles($filePath)
	{
		Storage::delete($filePath);

		$thumbPath = dirname($filePath) . DIRECTORY_SEPARATOR
			. 'thumbs' . DIRECTORY_SEPARATOR
			. basename($filePath);

		Storage::disk('public')->delete([
			$thumbPath, $filePath
		]);
	}
}
