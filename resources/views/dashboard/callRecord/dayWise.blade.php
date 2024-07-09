@extends('dash_layouts.aap', ['title' => 'Call Records'])
@section('content')


    <!-- /.card -->
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Call Records</h3>
        </div>

        <div class="card-body">
            <form action="{{route('callRecord.dayWise')}}" method="GET" class="form-inline mb-3">
                <div class="form-group mr-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <a href="{{route('callRecord.dayWise')}}" class="btn btn-secondary">Clear</a>
            </form>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Number</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Called At</th>
                    <th>Have to call</th>
                    <th>Call By</th>
                    {{-- <th>CSS grade</th> --}}
                </tr>
                </thead>
                <tbody>
                @foreach($callRecords as $record)
                    <tr>
                        <td>{{$record->number->phone_number}}</td>
                        <td>{{$record->status}}</td>
                        <td>{{$record->description}}</td>
                        <td>{{$record->created_at}}</td>
                        <td>{{$record->have_to_call}}</td>
                        <td>{{$record->user->name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
