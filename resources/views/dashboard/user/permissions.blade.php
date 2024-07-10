@extends('dash_layouts.aap', ['title' => 'Permissions'])
@section('content')

    <!-- /.card -->
    <div class="card">

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Permission name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>
                            {{$permission->name}}
                        </td>
                        <td>
                            <a href="{{route('user.permissionRemove', ['permission' => $permission->id, 'user' => $user])}}">Remove Permission</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


@endsection
