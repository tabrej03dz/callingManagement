@extends('dash_layouts.aap', ['title' => 'Create Status'])
@section('content')
    <!-- general form elements -->
    <div class="card">
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{route('status.store')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group mb-3">
                    <input name="name" type="text" class="form-control" placeholder="Name"/>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
    <!-- /.card -->
@endsection
