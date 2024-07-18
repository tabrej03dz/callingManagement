@extends('dash_layouts.aap', ['title' => 'Demos'])
@section('content')

    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$message->status}}</td>
                        <td>{{$message->message}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('message.edit', ['message' => $message])}}" class="btn btn-primary">Edit</a>
                                <a href="{{route('message.delete', ['message' => $message])}}" class="btn btn-warning">Delete</a>
                            </div>
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
