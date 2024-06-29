@extends('dash_layouts.aap', ['title' => 'Call Records'])
@section('content')


    <!-- /.card -->
    <div class="card">
        <form action="{{route('number.assignToUser')}}" method="post">
            @csrf
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->

            {{--            <div class="form-check">--}}
            {{--                <div class="form-group">--}}
            {{--                    <label>Select</label>--}}
            {{--                    <select class="form-control" name="user_id">--}}
            {{--                        <option value="">Select User</option>--}}
            {{--                        @foreach($users as $user)--}}
            {{--                            <option value="{{$user->id}}">{{$user->name}}</option>--}}
            {{--                        @endforeach--}}
            {{--                    </select>--}}
            {{--                    <input type="submit" value="Assign" class="btn btn-success">--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Called At</th>
                        <th>Have to call</th>
                        {{--                    <th>CSS grade</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>
                               {{$record->status->name}}
                            </td>
                            <td>{{$record->description}}</td>
                            <td>{{$record->created_at}}</td>
                            <td>{{$record->have_to_call}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
    <!-- /.card -->
@endsection
