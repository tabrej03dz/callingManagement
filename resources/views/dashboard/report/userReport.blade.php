@extends('dash_layouts.aap', ['title' => $user->name.' numbers'])
@section('content')

    <div class="card">
        <div class="card-head">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            @php
                                $callRecord = App\Models\CallRecord::whereDate('created_at', \Carbon\Carbon::today())->first();
                            @endphp
                            <h3>{{$callRecord?->created_at->format('h:i') ?? '__:__'}}</h3>

                            <p>First Call of day</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            @php
                                $callRecord = App\Models\CallRecord::whereDate('created_at', \Carbon\Carbon::today())->count();
                            @endphp
                            <h3>{{$callRecord}}</h3>

                            <p>Calls of the day</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            <!-- ./col -->

                @php
                    $assignedNumbersToUsersCount = App\Models\UserNumber::where('assigned_by' , $user->id )->whereDate('assigned_at' , Carbon\Carbon::today())->count();
                @endphp

                @if($user->hasRole('admin'))

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$assignedNumbersToUsersCount}}</h3>

                            <p>Assigned Numbers to Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif
                <!-- ./col -->
            </div>
        </div>
    </div>


    <!-- /.card -->
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Call Count</th>
                    <th>Last Call</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->userNumbers as $number)
                    @php
                        $record = $number->number->callRecords()?->latest()->first();
                        $phoneNumber = $number->number->phone_number;
                    @endphp
                    <tr>
                        <td>{{$phoneNumber}}</td>
                        <td>{{$number->number->status}}</td>
                        <td>{{$number->number->callRecords()->count()}}</td>
                        <td>{{$record?->created_at}}</td>
                        <td>{{$record?->description}}</td>
                        <td>
                            <a href="{{route('callRecord.show', ['number' => $number->number->id])}}">Call records</a>
                            <a href="{{route('user.unAssignNumber', ['userNumber' => $number->id])}}" class="btn btn-danger">Un Assign</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>



@endsection
