@extends('dash_layouts.aap', ['title' => 'Numbers'])
@section('content')

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        @role('super_admin|admin')
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">All</label>
                            </div>
                        </th>
                        @endrole

                        <th>Business Name</th>
                        <th>Phone Number</th>
                        <th>City</th>
                        <th>Assigned User</th>
                        {{--                    <th>CSS grade</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recentCalls as $call)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$call->number->business_name}}</td>
                            <td>{{$call->number->phone_number}}</td>
                            <td>{{$call->number->city}}</td>
                            <td>
                                {{$call->have_to_call}}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('callRecord.create', ['number' => $call->number->id]) }}"
                                       class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2">Response</a>
                                    <a href="{{route('callRecord.markAsRecalled', ['record' => $call->id])}}" class="btn btn-success btn-sm">Mark as Call</a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

@endsection
