@extends('dash_layouts.aap', ['title' => 'Numbers'])
@section('content')


    <!-- /.card -->
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
{{--                    <th>--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="selectAll">--}}
{{--                            <label class="form-check-label" for="selectAll">All</label>--}}
{{--                        </div>--}}
{{--                    </th>--}}
                    <th>Business Name</th>
                    <th>Phone Number</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Assigned User</th>
                    {{--                    <th>CSS grade</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($numbers as $number)
                    <tr>
{{--                        <td>--}}
{{--                            <div class="form-check">--}}
{{--                                <input class="form-check-input" name="numbers[]" value="{{$number->id}}" type="checkbox" id="{{$number->id}}" >--}}
{{--                                <label class="form-check-label"></label>--}}
{{--                            </div>--}}
{{--                        </td>--}}
                        <td>
                            <label class="form-check-label" for="{{$number->id}}">{{$number->business_name}}</label>
                        </td>
                        <td>{{$number->phone_number}}</td>
                        <td>{{$number->city}}</td>
                        <td>{{$number->assigned == '1' ? 'Assigned' : 'Not Assigned'}}</td>
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
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


    <!-- page script -->

@endsection
