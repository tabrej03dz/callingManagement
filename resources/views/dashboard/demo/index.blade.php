@extends('dash_layouts.aap', ['title' => 'Demos'])
@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{route('setInstanceAndAccess')}}" method="POST" class="form-inline">
                @csrf
                <div class="form-group mb-2 mr-2">
                    <input type="text" class="form-control" name="instance_id" value="{{ session('instance_id') ?? '' }}" placeholder="Instance Id">
                </div>
                <div class="form-group mb-2 mr-2">
                    <input type="text" class="form-control" name="access_token" value="{{ session('access_token') ?? '' }}" placeholder="Access Token">
                </div>
                <button type="submit" class="btn btn-primary mb-2 mr-2">Save</button>
                <a href="{{route('clearInstanceAndAccess')}}" class="btn btn-danger mb-2">Clear</a>
            </form>
        </div>
    </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($demoes as $demo)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$demo->name}}</td>
                        <td>{{$demo->city}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('demo.edit', ['demo' => $demo->id])}}" class="btn btn-primary">Edit</a>
                                <a href="{{route('demo.images', ['demo' => $demo])}}" class="btn btn-warning">Images</a>
                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    <!-- /.card -->

@endsection
