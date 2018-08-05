@extends('main_layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-xl-8">
            <form id="image-upload-form" action="{{route('uploadImage')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="images">Select images (can attach more than one):</label>
                    <input id="images" class="form-control-file" type="file" name="images[]"
                           accept=".jpg, .jpeg, .png, .svn, .bmp"
                           multiple max="10">
                </div>
                <hr>
                <div class="wrapper">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection
