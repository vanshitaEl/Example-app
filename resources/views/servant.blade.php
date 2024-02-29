<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servant Data</title>
</head>
<style>
    table,
    td,
    th {

        border: 1px solid black;

    }
</style>

<body>

    <h2>
        <center>SERVANT DATA</center>
    </h2>
    <center>
        <table>
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{ Auth::guard('servant')->user()->name }}</td>
                    <td>{{ Auth::guard('servant')->user()->email }}</td>
                    
                    <td> <a href="{{ route('logout') }}">Logout</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>
