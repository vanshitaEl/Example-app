@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left text-center">
                <h3>Patient Management System</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('create') }}"> Patient Report</a>
            </div><br>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <span>{{ $message }}</span>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Contact</th>
            <th>file</th>
            <th>Action</th>
        </tr>
        @foreach ($patients as $patient)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->contact }}</td>
                <td>{{ $patient->file }}</td>
                <td>
                    <form action="{{ route('doctor.patient.destroy', $patient->patient_id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('doctor.patient.show', $patient->patient_id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('doctor.patient.edit', $patient->patient_id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Do you really want to delete Patient!')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $patients->links() !!}
@endsection