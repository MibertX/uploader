<?php
Route::get('/', function () {
    return view('upload_form');
})->name('home');

Route::post('/upload', array(
    'uses' => 'MainController@uploadImage',
    'as' => 'uploadImage'
));

Route::middleware(['auth.basic'])->group( function() {
    Route::get('/uploaded-images', array(
        'uses' => 'MainController@uploadedImages',
        'as' => 'uploadedImages'
    ));
    
    Route::post('/delete-image/{id}', array(
        'uses' => 'MainController@deleteImage',
        'as' => 'deleteImage'
    ));
});
