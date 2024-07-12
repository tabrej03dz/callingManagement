@extends('dash_layouts.aap', ['title' => $status ?? 'All'.' Numbers'])
@section('content')


    <!-- /.card -->
    <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Phone Number</th>
                        <th>City</th>
                        <th>Msg</th>
                        <th>Date & Time</th>
                        <th>Assigned User</th>
                        {{--                    <th>CSS grade</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($numbers as $number)

                        <tr>
                            <td>
                                {{$number->business_name}}
                            </td>
                            <td>{{$number->phone_number}}</td>
                            <td>{{$number->city}}</td>
                            <td>{{$number->callRecords()->latest()->first()?->description}}</td>
{{--                            <td>{{$number->callRecords()->latest()->first()?->create_at->format('Y-m-d h:i')}}</td>--}}
                            <td>{{ $number->callRecords()->latest()->first()?->created_at ? \Illuminate\Support\Carbon::parse($number->callRecords()->latest()->first()->created_at)->format('d-F-Y H:i:s') : 'N/A' }}</td>

                            <td>
                                @foreach($number->userNumbers as $user)

                                    {{$user->user->name}}
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    <!-- /.card -->

@endsection
