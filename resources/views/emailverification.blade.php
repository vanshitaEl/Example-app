<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>verify email</title>
</head>
<body>
    {{-- @dd($token) --}}
     <a href="{{ route('doctor.verify',['token'=> $token]) }}" method="get">email verify</a>
     {{-- <input type="hidden" name="token" value="{{$token}}"> --}}
  
</body>
</html>