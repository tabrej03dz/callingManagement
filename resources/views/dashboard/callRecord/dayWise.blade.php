@extends('dash_layouts.aap', ['title' => 'Call Records'])
@section('content')


    <!-- /.card -->

    <div class="card">
        <div class="card-body">
            @php
                $users = App\Models\User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'super_admin');
                })->get();

            @endphp

            @foreach($users as $user)

                <a href="{{route('callRecord.statusWise', ['status' => $status ?? 'all', 'user' => $user->id])}}" class="btn btn-success">{{$user->name}}</a>
            @endforeach
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Count: {{$callRecords->count()}}</h3>
        </div>

        <div class="card-body">
            <form action="{{route('callRecord.statusWise', ['status' => $status ?? 'all', 'user' => $user])}}" method="GET" class="form-inline mb-3">
                <div class="row w-100">
                    <div class="col-12 col-sm-4 col-md-3 mb-2 mb-sm-0">
                        <input type="date" name="from" placeholder="From" class="form-control w-100">
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 mb-2 mb-sm-0">
                        <input type="date" name="to" placeholder="To" class="form-control w-100">
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 mb-2 mb-sm-0">
                        <button type="submit" class="btn btn-primary w-100 w-md-auto">Filter</button>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2">
                        <a href="{{route('callRecord.dayWise')}}" class="btn btn-secondary w-100 w-md-auto">Clear</a>
                    </div>
                </div>
            </form>


            <div class="table-responsive">
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


        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
