@extends('dash_layouts.aap')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @elseif(session('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                    <form action="{{route('dashboard')}}" method="GET">
                        <input type="date" name="date" placeholder="date">
                        <input type="submit" value="Filter" class="btn btn-primary">
                    </form>
                </div>
            </div>

            <!-- Small boxes (Stat box) -->
            <div class="row">
                @can('show all numbers')

                <div class="col-lg-3 col-6">
                    <!-- small box -->

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$allNumbers->count()}}</h3>

                            <p>Total Numbers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('number.statusWise')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>

                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{$numbers->where('status', 'interested')->count()}}<sup style="font-size: 20px"></sup></h3>

                            <p>Interested</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('number.statusWise', ['status' => 'interested'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->


                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$numbers->where('status', 'not interested')->count()}}</h3>

                                <p>Not Interested</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'not interested'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{$numbers->where('status', 'wrong number')->count()}}</h3>
                                <p>Wrong Numbers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'wrong number'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$numbers->where('status', 'converted')->count()}}</h3>
                                <p>Converted</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'converted'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @else
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{auth()->user()->userNumbers()->count()}}</h3>

                                <p>Total Assigned Numbers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{route('number.statusWise')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                @php
                                    $numberIds = auth()->user()->userNumbers()->pluck('number_id');
                                @endphp
                                <h3> {{$numbers->whereIn('id', $numberIds)->where('status', 'interested')->count()}}<sup style="font-size: 20px"></sup></h3>

                                <p>Interested</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'interested'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                @php
                                    $numberIds = auth()->user()->userNumbers()->pluck('number_id');
                                @endphp
                                <h3> {{$numbers->whereIn('id', $numberIds)->where('status', 'not interested')->count()}}<sup style="font-size: 20px"></sup></h3>

                                <p>Not Interested</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'not interested'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                @php
                                    $numberIds = auth()->user()->userNumbers()->pluck('number_id');
                                @endphp
                                <h3> {{$numbers->whereIn('id', $numberIds)->where('status', 'wrong interested')->count()}}<sup style="font-size: 20px"></sup></h3>
                                <p>Wrong Numbers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'wrong number'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                @php
                                    $numberIds = auth()->user()->userNumbers()->pluck('number_id');
                                @endphp
                                <h3> {{$numbers->whereIn('id', $numberIds)->where('status', 'wrong interested')->count()}}<sup style="font-size: 20px"></sup></h3>
                                <p>Converted</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('number.statusWise', ['status' => 'converted'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endcan




{{--                 @php--}}
{{--                     $callRecords = \App\Models\CallRecord::whereDate('created_at', \Carbon\Carbon::today())->get();--}}
{{--                 @endphp--}}

{{--                    <div class="col-lg-3 col-6">--}}
{{--                        <!-- small box -->--}}
{{--                        <div class="small-box bg-secondary">--}}
{{--                            <div class="inner">--}}
{{--                                <h3>{{$numbers->where('status', 'today call')->count()}}</h3>--}}
{{--                                <p>Today's Call </p>--}}
{{--                            </div>--}}
{{--                            <div class="icon">--}}
{{--                                <i class="ion ion-pie-graph"></i>--}}
{{--                            </div>--}}
{{--                            <a href="{{route('number.statusWise', ['status' => 'converted'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- ./col -->--}}


                    @if(auth()->user()->hasRole('calling team'))

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{$callRecords->where('user_id', auth()->user()->id)->count()}}</h3>
                                    <p>Today's Call</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('callRecord.statusWise')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>{{$callRecords->where('user_id', auth()->user()->id)->where('status', 'call back')->count()}}</h3>
                                    <p>Today's Call back</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('callRecord.statusWise', ['status' => 'call back'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{$callRecords->where('user_id', auth()->user()->id)->where('status', 'call not pick')->count()}}</h3>
                                    <p>
                                        Call not pic
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('callRecord.statusWise', ['status' => 'call not pick'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    @else
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-white" style="background-color:rebeccapurple">
                                <div class="inner">
                                    <h3>{{$callRecords->count()}}</h3>
                                    <p>Today's Call</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('callRecord.statusWise')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-dark">
                                <div class="inner">
                                    <h3>{{$callRecords->where('status', 'call back')->count()}}</h3>
                                    <p>Today's Call back</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('callRecord.statusWise', ['status' => 'call back'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{$callRecords->where('status', 'call not pick')->count()}}</h3>
                                    <p>
                                        Call not pic
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('callRecord.statusWise', ['status' => 'call not pick'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <!-- ./col -->

                    @endif

            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Sales
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart"
                                     style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- DIRECT CHAT -->
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-header">
                            <h3 class="card-title">Recent Call Reminder</h3>
                            <div class="card-tools">
                                <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                                        data-widget="chat-pane-toggle">
                                    <i class="fas fa-comments"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Number</th>
                                    <th>Remain Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentCalls as $call)
                                    <tr>
                                        <td><a href="tel:{{$call->number->phone_number}}">{{$call->number->phone_number}}</a></td>
                                        <td class="haveToCall" data-time="{{$call->have_to_call}}">
                                            {{$call->have_to_call}}
                                        </td>
                                        <td>{{$call->user->name}}</td>
                                        <td class="text-center">
                                            <a href="{{route('callRecord.markAsRecalled', ['record' => $call->id])}}" class="btn btn-success btn-sm">Mark as Call</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!--/.direct-chat -->

                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">

                    <!-- Map card -->
                    <div class="card bg-gradient-primary">
{{--                        <div class="card-header border-0">--}}
{{--                            <h3 class="card-title">--}}
{{--                                <i class="fas fa-map-marker-alt mr-1"></i>--}}
{{--                                Visitors--}}
{{--                            </h3>--}}
{{--                            <!-- card tools -->--}}
{{--                            <div class="card-tools">--}}
{{--                                <button type="button"--}}
{{--                                        class="btn btn-primary btn-sm daterange"--}}
{{--                                        data-toggle="tooltip"--}}
{{--                                        title="Date range">--}}
{{--                                    <i class="far fa-calendar-alt"></i>--}}
{{--                                </button>--}}
{{--                                <button type="button"--}}
{{--                                        class="btn btn-primary btn-sm"--}}
{{--                                        data-card-widget="collapse"--}}
{{--                                        data-toggle="tooltip"--}}
{{--                                        title="Collapse">--}}
{{--                                    <i class="fas fa-minus"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-tools -->--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <div id="world-map" style="height: 250px; width: 100%;"></div>--}}
{{--                        </div>--}}
                        <!-- /.card-body-->

                      @php
                          $userCount = \App\Models\User::role('calling team')->count();
                           $loggedInUsersToday = \App\Models\User::role('calling team')->whereDate('created_at', \Illuminate\Support\Carbon::today())->get();
                        @endphp

                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div id="sparkline-1"></div>
                                    <div class="text-white">All User</div>
                                    {{$userCount}}
                                </div>
                                <!-- ./col -->

                                <div class="col-4 text-center">
                                    <div id="sparkline-2"></div>
                                    <div class="text-white">Logged In Today</div>
                                    @foreach($loggedInUsersToday as $user)
                                        <div>{{ $user->name }}</div>
                                    @endforeach
                                </div>
                                <!-- ./col -->
                                <div class="col-4 text-center">
                                    <div id="sparkline-3"></div>
                                    <div class="text-white">Sales</div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- solid sales graph -->
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Sales Graph
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                                           data-fgColor="#39CCCC">

                                    <div class="text-white">Mail-Orders</div>
                                </div>
                                <!-- ./col -->
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                                           data-fgColor="#39CCCC">

                                    <div class="text-white">Online</div>
                                </div>
                                <!-- ./col -->
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                                           data-fgColor="#39CCCC">

                                    <div class="text-white">In-Store</div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->

                    <!-- Calendar -->
                    <div class="card bg-gradient-success">
                        <div class="card-header border-0">

                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Calendar
                            </h3>
                            <!-- tools card -->
                            <div class="card-tools">
                                <!-- button with a dropdown -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-bars"></i></button>
                                    <div class="dropdown-menu float-right" role="menu">
                                        <a href="#" class="dropdown-item">Add new event</a>
                                        <a href="#" class="dropdown-item">Clear events</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">View calendar</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <!--The calendar -->
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


{{--    <div class="haveToCall" data-time="2024-07-10T12:00:00Z" data-audio="{{ asset('asset/musical_alarm.mp3') }}">Placeholder Text</div>--}}

{{--    <script>--}}
{{--        window.onload = function() {--}}
{{--            const rows = document.querySelectorAll('.haveToCall');--}}

{{--            rows.forEach(row => {--}}
{{--                const haveToCallTime = new Date(row.dataset.time);--}}
{{--                const alarmUrl = row.dataset.audio;--}}

{{--                // Create an audio element for the alarm--}}
{{--                const alarm = new Audio(alarmUrl);--}}
{{--                let alarmPlayed = false;--}}

{{--                setInterval(() => {--}}
{{--                    const now = new Date();--}}
{{--                    const timeDifference = Math.max(0, haveToCallTime - now); // Ensure non-negative value--}}

{{--                    // Calculate hours, minutes, and seconds from timeDifference--}}
{{--                    const hours = Math.floor(timeDifference / (1000 * 60 * 60));--}}
{{--                    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));--}}
{{--                    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);--}}

{{--                    // Format the time difference as a string--}}
{{--                    const formattedTime = `${hours}h ${minutes}m ${seconds}s`;--}}

{{--                    // Update the row's text content--}}
{{--                    row.textContent = formattedTime;--}}


{{--                    // Play alarm and show alert if time difference is less than or equal to 1 minute and alarm has not played yet--}}
{{--                    if (timeDifference <= 60000 && !alarmPlayed) {--}}
{{--                        alarm.play();--}}
{{--                        alert("One minute remaining!");--}}
{{--                        alarmPlayed = true;--}}
{{--                    }--}}



{{--                    // Optional: console log the time difference for debugging--}}
{{--                    console.log(`Time difference for this row: ${formattedTime}`);--}}
{{--                }, 1000); // 1000 milliseconds = 1 second--}}
{{--            });--}}
{{--        };--}}
{{--    </script>--}}
@endsection
