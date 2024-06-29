@extends('dash_layouts.aap', ['title' => 'Roles'])
@section('content')
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Action</th>
                {{--                <th style="width: 40px">Label</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <div class="btn-group">
{{--                            <a href="{{route('role.edit', ['role' => $role])}}" class="btn btn-primary">Edit</a>--}}
                            <a href="{{route('role.delete', ['role' => $role])}}" class="btn btn-danger">Delete</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
