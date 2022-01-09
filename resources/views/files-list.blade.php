@inject('helper', 'App\Http\Helper')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files List</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

</head>
<body>
<div class="container">
    <div class="row" style="margin-top: 45px">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Files</div>
                <div class="card-body">
                    <table class="table table-hover table-condensed" id="files-table">
                        <thead>
                        <th><input type="checkbox" name="main_checkbox"><label></label></th>
                        <th>#</th>
                        <th>File name</th>
                        <th>Format</th>
                        <th>Size</th>
                        <th>Actions <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete All</button></th>
                        </thead>
                        <tbody>
                        @foreach ($files as $key => $file)
                        <tr>
                            <td><input type="checkbox" data-id="{{$file->id}}" name="file_checkbox"></td>
                            <td>{{++$key}}</td>
                            <td>{{$file->name}}</td>
                            <td>{{$file->format}}</td>
                            <td>{{ $helper->getReadableFileSize($file->size) }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-success" href="{{ route('download', $file->id)}}" target="_blank" id="downloadFileBtn">Download</a>
                                    <button class="btn btn-sm btn-primary" data-id="{{$file->id}}" id="editFileBtn">Update</button>
                                    <button class="btn btn-sm btn-danger" data-id="{{$file->id}}" id="deleteFileBtn" >Delete</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add new File</div>
                <div class="card-body">
                    <form action="{{ route('upload') }}" method="post" id="add-file-table" enctype="multipart/form-data">

                        @csrf
                        @if(Session::has('isUploaded'))
                            @if(Session::get('isUploaded'))
                                <div class="alert alert-success">
                                    File uploaded successfully !
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    Something went wrong. Please try again
                                </div>
                            @endif
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="chooseFile">
                            <label class="custom-file-label" for="chooseFile">Choose file</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                            Upload Files
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@include('edit-file-name-modal')
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/custom.js') }}"></script>

</body>
</html>
