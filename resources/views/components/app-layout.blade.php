@props(['content' => null])

<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div>
        {{ $slot }}
    </div>

</body>

</html>
