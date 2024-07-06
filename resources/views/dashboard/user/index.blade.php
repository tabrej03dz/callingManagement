@extends('dash_layouts.aap', ['title' => 'All Users'])
@section('content')
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
    {{--                <th style="width: 40px">Label</th>--}}
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->getRoleNames()}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('user.edit', ['user' => $user])}}" class="btn btn-primary">Edit</a>
                            <a href="{{route('user.delete', ['user' => $user])}}" class="btn btn-danger">Delete</a>
                            <a href="{{route('user.assignedNumbers', ['user' => $user])}}" class="btn btn-danger">Assigned Numbers</a>
                            <a href="{{route('user.permissions', ['user' => $user])}}" class="btn btn-danger">Permissions</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
