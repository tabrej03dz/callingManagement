@extends('dash_layouts.aap', ['title' => 'Create Demo'])
@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Demo</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{route('demo.update', ['demo' => $demo])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputFile">Name</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="name" value="{{$demo->name ?? ''}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">City</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="city" value="{{$demo->city ?? ''}}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">Description</label>
                    <textarea name="description" id="" cols="30" rows="8" class="form-control" placeholder="Write Here">
{{$demo->description ?? ''}}
                    </textarea>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
