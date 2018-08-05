<!DOCTYPE html>
<html>
<head>
    <title>Uploader</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
          crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous">
    </script>

    <script src="/jquery_plugins/toastr/js/toastr.min.js"></script>
    <link href="/jquery_plugins/toastr/css/toastr.min.css" rel="stylesheet">

    <script src="/jquery_plugins/wait_me/js/wait_me.min.js"></script>
    <link href="/jquery_plugins/wait_me/css/wait_me.min.css" rel="stylesheet">

    <script src="/js/upload.js"></script>
    <link href="/css/upload.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{route('home')}}">Laravel Image Uploader</a>
        <a href="{{route('uploadedImages')}}">Uploaded Images</a>
    </nav>
    <div class="container-fluid">
        @yield('content')
    </div>
</body>
</html>
