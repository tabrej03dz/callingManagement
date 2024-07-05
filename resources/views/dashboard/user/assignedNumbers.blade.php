@extends('dash_layouts.aap', ['title' => 'Assigned Numbers to '. $user->name])
@section('content')


    <!-- /.card -->
    <div class="card" style="overflow-x: auto;">
        <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Phone Number</th>
                    <th>City</th>
                    <th>Response</th>
                    <th>Description</th>
                    <th>Last Call</th>
                    <th>Have to call</th>
                    <th>Count</th>
                    @role('super_admin')
                    <th>Assigned User</th>
                    @endrole
                    <th>Action</th>
                    {{--                    <th>CSS grade</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($user->userNumbers as $number)
                    @php
                        $record = $number->number->callRecords()->latest()->first();
                        //dd($record->status);
                    @endphp
                    <tr>
                        <td>{{$number->number->phone_number}}</td>
                        <td>{{$number->number->city}}</td>
                        <td>{{$record?->status->name}}</td>
                        <td>{{$record?->description}}</td>
                        <td>{{$record?->created_at}}</td>
                        <td>{{$record?->have_to_call}}</td>
                        <td>{{$number->number->callRecords->count()}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('callRecord.show', ['number' => $number->id])}}" class="btn btn-primary">Call Records</a>
                                {{--                                    <a href="tel" class="btn btn-primary">Call Records</a>--}}
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
