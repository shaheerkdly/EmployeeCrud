@extends('admin.layout')

@section('styles')
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Edit Employee</h4>
                    </div>
                    <!-- form start -->
                    <form action="{{ route('update', $employee->id) }}" method="POST" id="employee-form-edit" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" required=""
                                    name="name" value="{{ $employee->name }}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" required=""
                                    name="email" value="{{ $employee->email }}">
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <select name="designation" class="form-control" required id="designation">
                                    <option value="">Select designation</option>
                                    @foreach($designations as $key => $designation)
                                    <option value="{{ $key }}" {{ $employee->designation_id == $key ? 'selected' : '' }}>
                                        {{ $designation }}</option>
                                    @endforeach
                                </select>
                                @error('designation')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Photo Upload</label>
                                <div class="input-group">
                                    <input type="file" id="image" name="image" accept="image/*">
                                    @if($employee->image)
                                    @endif
                                </div>
                                @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($employee->image)
                            <div class="form-group" id="imageDiv">
                                <label for="delete_image">Delete Photo</label>
                                <input type="checkbox" id="delete_image" name="delete_image" value="1">
                                <div class="input-group" id="imageDisplay">
                                    <a href="{{ asset('images/' . $employee->image) }}" target="_blank">
                                        <img src="{{ asset('images/' . $employee->image) }}" width="150 px"
                                            height="150 px">
                                    </a>
                                </div>
                            </div>
                            @endif

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $('#image').change(function() {
        $("#imageDiv").hide()
        $( "#delete_image" ).prop( "checked", false );
    });
    $("#delete_image").click(function () {
        if ($(this).is(":checked")) {
            $("#imageDisplay").hide();
        } else {
            $("#imageDisplay").show();
        }
    });
</script>
@endsection
