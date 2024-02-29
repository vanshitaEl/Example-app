<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soft Deleted Data</title>
</head>
<style>
    table,
    th,
    td {
        font-family: arial, sans-serif;
        border: 1px solid black;
        border-collapse: collapse;
        }
</style>

<body>
    <h1> <center> Soft Deleted Data </center></h1>
<center>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($patients) > 0)

                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient->patient_id }}</td>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->contact }}</td>
                                <td>{{ $patient->file }}</td>
                                {{-- <td><img src="{{ asset('storage/file/' . $patient->file) }}" width="100px" height="50px" alt="Image"></td> --}}
                        @endforeach
                        </tr>
            </table>
        </div>
    </div>
</center>
@else
    <p>No soft-deleted records found.</p>
    @endif
</body>

</html>
