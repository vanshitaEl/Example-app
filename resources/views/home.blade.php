<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>notification</title>
    {{-- <script src="resources/js/script.js" defer></script> --}}
    {{-- @vite(['resources/js/script.js']) --}}
</head>
<body>
     @foreach ($nice as $item)
        1. {{$item}} <br/>
     @endforeach
</body>
</html>