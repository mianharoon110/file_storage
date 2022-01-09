<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
</head>
<body>
    <div class="row" style="margin-top: 30px">
        <div class="col-md-12">
            <h4 style="margin-left: 30px">File Storage</h4><hr>
            <table class="table table-hover" >
                <thead style="background-color:#f7f7f7">
                <th>Name</th>
                <th>Email</th>
                <th></th>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a style="color: #f44336" href="{{ route('auth.logout') }}">Logout</a></td>
                </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
@include('files-list')
</body>
</html>
