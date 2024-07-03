@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')


    <!-- /.card -->
    <div class="card" style="overflow-x: auto;">
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->

{{--            <div class="form-check">--}}
{{--                <div class="form-group">--}}
{{--                    <label>Select</label>--}}
{{--                    <select class="form-control" name="user_id">--}}
{{--                        <option value="">Select User</option>--}}
{{--                        @foreach($users as $user)--}}
{{--                            <option value="{{$user->id}}">{{$user->name}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <input type="submit" value="Assign" class="btn btn-success">--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" >
                    <thead>
                    <tr>
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
                    @foreach($numbers as $number)
                        @php
                            $record = $number->callRecords()->latest()->first();
                            //dd($record->status);
                        @endphp
                        <tr>
                            @role('super_admin|admin')
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" name="numbers[]" value="{{$number->id}}" type="checkbox" id="{{$number->id}}" >
                                    <label class="form-check-label"></label>
                                </div>
                            </td>
                            @endrole
                            <td>
                                <label class="form-check-label" for="{{$number->id}}">{{$number->business_name}}</label>
                            </td>
                            <td>{{$number->phone_number}}</td>
                            <td>{{$number->city}}</td>
                            <td>{{$record?->status->name}}</td>
                            <td>{{$record?->description}}</td>
                            <td>{{$record?->created_at}}</td>
                            <td>{{$record?->have_to_call}}</td>
                            <td>{{$number->callRecords->count()}}</td>
                            @role('super_admin|admin')
                            <td>
                                <ul style="list-style: none; padding: 0px;">
                                    @foreach($number->userNumbers as $user)
                                        <li>{{$user->user->name}}</li>
                                    @endforeach
                                </ul>
                            </td>
                            @endrole

                            <td>
                                <div class="btn-group">
{{--                                    <a href="tel:918423269465">Call</a>--}}
                                    <a href="javascript:void(0);" class="btn btn-warning" data-toggle="modal" data-target="#callModal">Call</a>

                                    <a href="{{route('callRecord.create', ['number' => $number->id])}}" class="btn btn-warning">Create Response</a>
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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="numbers[]"]');

            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });
    </script>

    <!-- Modal -->
{{--    <div class="modal fade" id="callModal" tabindex="-1" role="dialog" aria-labelledby="callModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="callModalLabel">Call Confirmation</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    Do you want to call this number: +91{{$number->phone_number}}?--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>--}}
{{--                    <a href="tel:+91{{$number->phone_number}}" class="btn btn-primary">Call</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
@endsection
