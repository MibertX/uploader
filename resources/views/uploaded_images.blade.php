@extends('main_layout')

@section('content')
    {{csrf_field()}}
    <table id="uploaded-images-table" class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Original Name</th>
            <th scope="col">Size</th>
            <th scope="col">Upload Date</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($images as $image)
            @php($imageFileExist = Storage::disk('public')->exists($image->path))
            <tr>
                <th scope="row">{{$image->id}}</th>
                <td>
                    @if ($imageFileExist)
                        <a href="{{Storage::url($image->path)}}" target="_blank">
                            {{basename($image->path)}}
                        </a>
                    @else
                        <span>File "{{basename($image->path)}}" not found.</span>
                    @endif
                </td>
                <td>{{$image->original_name}}</td>
                <td>
                    @if ($imageFileExist)
                        {{round(Storage::disk('public')->size($image->path) / 1000) . ' Kbs'}}
                    @endif
                </td>
                <td>{{$image->created_at}}</td>
                <td>
                    <a type="button" class="btn btn-danger delete-image"
                       href="{{route('deleteImage', array('id' => $image->id))}}">
                        Delete
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
