@extends('dash_layouts.aap', ['title' => 'Create Demo'])
@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Demo</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{route('demo.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputFile">Name</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">City</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="city" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Image Title</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="image_title" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">Images</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="images[]" multiple class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
