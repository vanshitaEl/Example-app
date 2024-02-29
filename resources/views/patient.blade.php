<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laravel Ajax CRUD Data Table for Database with Modal Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }

        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            min-width: 1000px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            min-width: 100%;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        table.table tr th:first-child {
            width: 60px;
        }

        table.table tr th:last-child {
            width: 100px;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #F44336;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }

        /* Modal styles */
        .modal .modal-dialog {
            max-width: 400px;
        }

        .modal .modal-header,
        .modal .modal-body,
        .modal .modal-footer {
            padding: 20px 30px;
        }

        .modal .modal-content {
            border-radius: 3px;
            font-size: 14px;
        }

        .modal .modal-footer {
            background: #ecf0f1;
            border-radius: 0 0 3px 3px;
        }

        .modal .modal-title {
            display: inline-block;
        }

        .modal .form-control {
            border-radius: 2px;
            box-shadow: none;
            border-color: #dddddd;
        }

        .modal textarea.form-control {
            resize: vertical;
        }

        .modal .btn {
            border-radius: 2px;
            min-width: 100px;
        }

        .modal form label {
            font-weight: normal;
        }

        .loading {
            color: black;
            font: 300 2em/100% Impact;
            text-align: center;
        }

        /* loading dots */

        .loading:after {
            content: ' .';
            animation: dots 1s steps(5, end) infinite;
        }

        @keyframes dots {

            0%,
            20% {
                color: rgba(0, 0, 0, 0);
                text-shadow:
                    .25em 0 0 rgba(0, 0, 0, 0),
                    .5em 0 0 rgba(0, 0, 0, 0);
            }

            40% {
                color: black;
                text-shadow:
                    .25em 0 0 rgba(0, 0, 0, 0),
                    .5em 0 0 rgba(0, 0, 0, 0);
            }

            60% {
                text-shadow:
                    .25em 0 0 black,
                    .5em 0 0 rgba(0, 0, 0, 0);
            }

            80%,
            100% {
                text-shadow:
                    .25em 0 0 black,
                    .5em 0 0 black;
            }
        }
    </style>
</head>

<body>
    <center> </center>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="bg-light p-2 m-2">
                        <h5 class="text-dark text-center">Larave Ajax CRUD operation</h5>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Patients</b>Auth:{{ auth()->id() }}</h2>
                        </div>
                        <div class="col-sm-6">

                            <b><a href="{{ route('doctor.chat', ['lang' => app()->getLocale(), 'id' => 1]) }}" class="btn btn-success"><i class="material-icons">&#xE0b7;</i><span>Chat 1</span></a></b>
                            <b><a href="{{ route('doctor.chat', ['lang' => app()->getLocale(), 'id' => 2]) }}" class="btn btn-success"><i class="material-icons">&#xE0b7;</i><span>Chat 2</span></a></b>
                            <b><a href="{{ route('doctor.chat', ['lang' => app()->getLocale(), 'id' => 3]) }}" class="btn btn-success"><i class="material-icons">&#xE0b7;</i><span>Chat 3</span></a></b>
                            <b><a href="{{ route('doctor.chat', ['lang' => app()->getLocale(), 'id' => 4]) }}" class="btn btn-success"><i class="material-icons">&#xE0b7;</i><span>Chat 4</span></a></b>
                            <b><a href="{{ route('doctor.chat', ['lang' => app()->getLocale(), 'id' => 5]) }}" class="btn btn-success"><i class="material-icons">&#xE0b7;</i><span>Chat 5</span></a></b>
                            <b><a href="{{ route('doctor.chat', ['lang' => app()->getLocale(), 'id' => 7]) }}" class="btn btn-success"><i class="material-icons">&#xE0b7;</i><span>Chat 7</span></a></b>
                            <a href="#addPatientModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Patient</span></a>
                            <a href="{{ route('doctor.patient_trash', ['lang' => app()->getLocale()]) }}" class="btn btn-danger">View Deleted Patients</a>
                            {{-- <a  class="m-1"  onclick="trash()">View Deleted Patients</a> --}}
                            {{-- <button type="button" id="" onclick="trash()">View Deleted Patients</button> --}}
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Name</th>
                            <th>contact</th>
                            <th>file</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patient_data">
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Add Modal HTML -->
    <div id="addPatientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Patient</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form enctype="multipart/form-data" id="submitdata" method="post">
                    @csrf
                    @auth('doctor')
                    @endauth
                    <div class="modal-body add_patient">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name_input" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>contact</label>
                            <input type="text" name="contact" id="contact_input" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>file</label>
                            <input type="file" name="file" id="file_input" class="form-control" required />
                        </div>

                        <input type="hidden" value="{{ Auth::id() }}" name="doctor_id" id="doctor_id" class="form-control" required />
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            $("#submitdata").submit(function(event) {
                event.preventDefault();
                // let id = $('#doctor_id').val();
                // let url = "{{ route('api.store', ['doctor' => ':id']) }}";
                // var path = url.replace(":id", id);


                const form = document.getElementById("submitdata");
                var formData = new FormData(form);

                $.ajax({
                    type: 'post',
                    data: formData,

                    contentType: false,
                    processData: false,
                    url: "{{ route('api.store') }}",

                    success: function(response) {
                        $('#addPatientModal').modal('hide');
                        patientList();
                        alert(response.message);
                    }
                });

                for (const [key, value] of formData) {
                    console.log(`${key}: ${value}\n`);
                }

            })
        });
    </script>

    <!-- Edit Modal HTML -->

    <div id="editPatientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">edit Patient</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form enctype="multipart/form-data" id="updatedata" method="post">
                    {{-- @method('PUT') --}}
                    @csrf
                    <div class="modal-body edit_patient">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name_edit" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>contact</label>
                            <input type="text" name="contact" id="contact_edit" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>file</label>
                            <input type="file" name="file" id="file_edit" class="form-control" />
                            <input type="hidden" name="patient_id" id="patient_id" class="form-control" required />
                        </div>
                        <input type="hidden" value="{{ Auth::id() }}" name="doctor_id" id="doctor_id" class="form-control" required />
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                        <button type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $("#updatedata").submit(function(event) {
                event.preventDefault();
                let id = $('#patient_id').val();
                let url = "{{ route('api.update', ['id' => ':id']) }}";
                var path = url.replace(":id", id);

                const form = document.getElementById("updatedata");
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    url: path,
                    success: function(response) {
                        $('#editPatientModal').modal('hide');
                        patientList();
                        alert(response.message);
                    }

                });
                for (const [key, value] of formData) {
                    console.log(`${key}: ${value}\n`);
                }

            })
        });
    </script>


    <!-- View Modal HTML -->
    <div id="viewPatientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Patient</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body view_patient">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name_input" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" id="contact_input" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" id="file_input" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
                </div>
            </div>
        </div>
    </div>

    {{-- <ul>
        @foreach ($patient as $patient)
        <li>{{$patient->file}}<img src="{{asset('storage/file'.$patient->file)}}"></li>
        @endforeach
    </ul> --}}




    <script>
        $(document).ready(function() {

            patientList();
        });

        function patientList() {

            $.ajax({
                type: 'post',
                url: "{{ route('api.list') }}",
                data: {
                    doctor_id: "{{ auth()->id() }}"
                },
                success: function(response) {
                    console.log(response);
                    var tr = '';
                    for (var i = 0; i < response.data.data.length; i++) {
                        let patient = response.data.data[i]
                        var patient_id = patient.patient_id;
                        var name = patient.name;
                        var contact = patient.contact;
                        var file = patient.file_url;

                        console.log('File URL:', file);
                        
                        tr += '<tr>';
                        tr += '<td>' + patient_id + '</td>';
                        tr += '<td>' + name + '</td>';
                        tr += '<td>' + contact + '</td>';
                        tr += '<td><img src="' + file + '" width="100px" height="100px"></td>';

                        tr += '<td><div class="d-flex">';

                        tr +=
                            `<a href="#editPatientModal" class="m-1 edit" data-toggle="modal" onclick='editPatient(` + patient_id + `)'><b>Edit</b></a>`;
                        tr +=
                            `<a  class="m-1 delete" data-toggle="modal" onclick='deletePatient(` + patient_id + `)'>Delete</a>`;

                        tr += '</div></td>';
                        tr += '</tr>';
                    }
                    $('.loading').hide();
                    $('#patient_data').html(tr);
                }
            });
        }
    </script>


    <center> <a href="{{ route('doctor.logout', ['lang' => app()->getLocale()]) }}">logout</a></center>

    <script>
        function editPatient(id) {
            console.log(id);

            let url = "{{ route('patient_edit', ['id' => ':id']) }}";
            console.log(url);
            var path = url.replace(':id', id);
            console.log(path);
            $.ajax({
                type: 'get',
                url: path,
                success: function(response) {
                    console.log(response);
                    $(' #name_edit').val(response.name);
                    $(' #contact_edit').val(response.contact);
                    $('#patient_id').val(response.patient_id);
                    $(' #name_edit').val(response.name);
                    $(' #contact_edit').val(response.contact);

                }
            })
        }
    </script>

    <script>
        function deletePatient(id) {
            // alert('delete');
            $.ajax({
                type: 'post',
                url: "{{ route('api.delete') }}",
                data: {
                    id: id,
                },
                success: function(response) {
                    patientList();
                    alert(response.message);

                }
            })
        }
    </script>




    <!-- Delete Modal HTML -->
    <div id="deletePatientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Patient</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <form enctype="multipart/form-data" id="deletedata" method="post">

                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <input type="hidden" id="delete_id" name="delete_id">
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
            </div>
        </div>
    </div>


    <script>
        function trash() {
            $.ajax({
                url: "{{ route('doctor.patient_trash', ['lang' => app()->getLocale()]) }}",
                type: 'get',
                dataType: 'json',
                success: function(data) {

                    // Handle the data returned from the server (e.g., update the UI)
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }
    </script>


</body>

</html>
