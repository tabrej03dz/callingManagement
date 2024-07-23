@extends('dash_layouts.aap', ['title' => $user->name . ' numbers'])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('report.user', ['user' => $user]) }}" method="get">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-sm-auto mb-3 mb-sm-0">
                        <input type="date" name="date" class="form-control" placeholder="Date">
                    </div>
                    <div class="col-12 col-sm-auto mb-3 mb-sm-0">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <a href="{{ route('report.user', ['user' => $user]) }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


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
                                $loggedAt = App\Models\UserLog::whereDate(
                                    'created_at',
                                    $date ?? \Carbon\Carbon::today(),
                                )
                                    ->where('user_id', $user->id)
                                    ->first();
                            @endphp
                            <h3>{{ $loggedAt?->created_at->format('h:i') ?? '__:__' }}</h3>

                            <p>Logged At</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            @php
                                $callRecord = App\Models\CallRecord::whereDate(
                                    'created_at',
                                    $date ?? \Carbon\Carbon::today(),
                                )
                                    ->where('user_id', $user->id)
                                    ->first();
                            @endphp
                            <h3>{{ $callRecord?->created_at->format('h:i') ?? '__:__' }}</h3>

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
                                $callRecord = App\Models\CallRecord::whereDate(
                                    'created_at',
                                    $date ?? \Carbon\Carbon::today(),
                                )
                                    ->where('user_id', $user->id)
                                    ->count();
                            @endphp
                            <h3>{{ $callRecord }}</h3>

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
                    $assignedNumbersToUsersCount = App\Models\UserNumber::where('assigned_by', $user->id)
                        ->whereDate('assigned_at', $date ?? Carbon\Carbon::today())
                        ->count();
                @endphp

                @if ($user->hasRole('admin'))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $assignedNumbersToUsersCount }}</h3>

                                <p>Assigned Numbers to Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
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
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">Phone Number</th>
                                <th style="min-width: auto;">Status</th>
                                <th style="min-width: auto;">Call Count</th>
                                <th style="min-width: 100px;">Last Call</th>
                                <th style="min-width: auto;">Description</th>
                                <th style="min-width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userNumbers as $number)
                                @php
                                    $record = $number->number->callRecords()?->latest()->first();
                                    $phoneNumber = $number->number->phone_number;
                                @endphp
                                <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Phone Number: </span>
                                        <a href="tel:{{ $phoneNumber }}">{{ $phoneNumber }}</a>
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Status: </span>
                                        {{ $number->number->status }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Call Count: </span>
                                        {{ $number->number->callRecords()->count() }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Last Call: </span>
                                        {{ $record?->created_at ? $record->created_at->format('d-M H:i') : 'N/A' }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Description: </span>
                                        {{ $record?->description ?? 'N/A' }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Action: </span>
                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                            <a href="{{ route('callRecord.show', ['number' => $number->number->id]) }}"
                                               class="btn btn-primary btn-sm w-100 w-sm-auto mb-2 mb-sm-0">
                                                Call records
                                            </a>
                                            @role('super_admin|admin')
                                                <a href="{{ route('user.unAssignNumber', ['userNumber' => $number->id]) }}"
                                                   class="btn btn-danger btn-sm w-100 w-sm-auto">
                                                    Un Assign
                                                </a>
                                            @endrole
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media (max-width: 768px) {
            .title-name-header {
                display: none;
            }
        }
    </style>
@endsection
