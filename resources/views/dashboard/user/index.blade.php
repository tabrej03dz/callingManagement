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
{{--                    <td>--}}
{{--                        <div class="progress progress-xs progress-striped active">--}}
{{--                            <div class="progress-bar bg-success" style="width: 90%"></div>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                    <td><span class="badge bg-success">90%</span></td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
