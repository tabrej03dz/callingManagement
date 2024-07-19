@extends('dash_layouts.aap', ['title' => 'Demo Records'])
@section('content')


    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Number</th>
                <th>Demo Name</th>
                <th>Custom Message</th>
                <th>Sent By</th>
                <th>Sent At</th>
            </tr>
            </thead>
            <tbody>
                @foreach($demoRecords as $record)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$record->number->business_name}}</td>
                        <td>{{$record->number->phone_number}}</td>
                        <td>{{$record->demo?->name}}</td>
                        <td>{!! $record->custom_message !!}</td>
                        <td>{{$record->user->name}}</td>
                        <td>{{$record->created_at->format('D-m h:i')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <!-- /.card -->

@endsection
