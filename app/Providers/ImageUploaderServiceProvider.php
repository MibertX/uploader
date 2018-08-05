<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ImageUploader;
use App\Services\SimpleImageUploader;

class ImageUploaderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ImageUploader::class, function() {
            return new SimpleImageUploader();
        });
    }
}
