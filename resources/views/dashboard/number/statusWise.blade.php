@extends('dash_layouts.aap', ['title' => ($status ?? 'All') . ' Numbers'])
@section('content')
    <style>
        .neutralColor{
            background-color: #f57102;
        }
    </style>
<div class="card">
    <div class="card-body">
        <form action="{{route('number.statusWise', ['status' => $status])}}" method="GET" class="form-inline mb-3">
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
                    <a href="{{route('number.statusWise', ['status' => $status])}}" class="btn btn-secondary w-100 w-md-auto">Clear</a>
                </div>
            </div>
        </form>

        @php
            //$users = App\Models\User::whereDoesntHave('roles', function ($query) {
            //    $query->where('name', 'super_admin');
            //})->get();
            $users = App\Models\User::all();

        @endphp
        <div class="row">
            @foreach($users as $user)
                @if($user->hasRole('super_admin'))
                    @continue
                @endif
                @if(!auth()->user()->hasRole(['super_admin', 'admin']))
                    @if(auth()->user()->id != $user->id)
                        @continue
                    @endif
                @endif
                @php
                    if ($status == 'interested'){
                        $bgColor = 'bg-primary';
                    }elseif($status == 'not interested'){
                        $bgColor = 'bg-danger';
                    }elseif($status == 'wrong number'){
                        $bgColor = 'bg-secondary';
                    }else{
                        $bgColor = 'bg-success';
                    }
                @endphp

                <div class="col-lg-2 col-4">
                    <!-- small box -->
                    <div class="small-box {{$status == 'neutral'? 'neutralColor' : $bgColor}}">
                        <div class="inner">
                            @php
                                $numberIds = \App\Models\UserNumber::where('user_id', $user->id)->pluck('number_id');
                                $numberRecords = \App\Models\Number::whereIn('id', $numberIds);
                                if ($from == null && $to == null){
                                    $numberRecords = $numberRecords->whereDate('updated_at', \Carbon\Carbon::today());
                                }else{
                                    $numberRecords = $numberRecords->whereBetween('updated_at', [$from, $to]);
                                }
                                if ($status != 'all'){
                                    $numberRecords = $numberRecords->where('status', $status);
                                }
                                $numberRecords = $numberRecords->get();
                            @endphp
                            <h3> {{$numberRecords->count()}}<sup style="font-size: 20px"></sup></h3>
                            <p>{{$user->name}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        {{--                        <a href="{{route('number.statusWise', ['status' => 'converted'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
    <div class="card" style="overflow-x: auto;">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">Business Name</th>
                                <th style="min-width: auto;">Owner Name</th>
                                <th style="min-width: auto;">Phone Number</th>
                                <th style="min-width: auto;">City</th>
                                <th style="min-width: auto;">Msg</th>
                                <th style="min-width: auto;">Date & Time</th>
                                <th style="min-width: auto;">Assigned User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($numbers as $number)
                                <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Business Name: </span>
                                        {{ $number->business_name }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Owner Name: </span>
                                        <a href="tel:{{ $number->number }}">{{ $number->name }}</a>
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Phone Number: </span>
                                        <a href="tel:{{ $number->phone_number }}">{{ $number->phone_number }}</a>
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">City: </span>
                                        {{ $number->city }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Msg: </span>
                                        {{ $number->callRecords()->latest()->first()?->description ?? 'N/A' }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Date & Time: </span>
                                        @php
                                            $latestCallRecord = $number->callRecords()->latest()->first();
                                        @endphp
                                        {{ $latestCallRecord ? $latestCallRecord->created_at->format('d-M-Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Assigned User: </span>
                                        @forelse($number->userNumbers as $user)
                                            {{ $user->user->name }}{{ !$loop->last ? ', ' : '' }}
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No numbers found</td>
                                </tr>
                            @endforelse
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

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, .05);
            }

            .d-md-table-cell {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }
        }
    </style>

@endsection
