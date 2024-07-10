@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


    @if (session()->has('alreadyAssigned') && session('alreadyAssigned'))
        <div class="card">
            <div class="card-head">
                <h6 class="ml-4 mt-3 mb-0">These numbers had been assigned to another user</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <form action="{{route('number.unAssign')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Assigned Numbers</th>
                                    <th scope="col">Assigned User</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(session('alreadyAssigned') as $assigned)
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <input type="checkbox" name="alreadyAssignedNumbers[]" hidden checked value="{{$assigned->id}}" class="mr-2">
                                            <span>{{$assigned->number->phone_number}}</span>
                                        </td>
                                        <td>
                                            @foreach($assigned->number->userNumbers as $userNumber)
                                                <span>Name: {{$userNumber->user?->name}}, Assigned At: {{$userNumber->assigned_at}}, Assigned By: {{$userNumber->assignedBy?->name}}</span>
                                                <br>
                                            @endforeach

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger mr-2" value="Cancel">
                            <a href="{{route('number.index')}}" class="btn btn-success">Yes! Keep It</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- /.card -->
    <div class="card">

        <form action="{{route('number.assignToUser')}}" method="post">
            @csrf
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="userSelect" class="col-form-label">Select User</label>
                        <select class="form-control" id="userSelect" name="user_id">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="roleSelect" class="col-form-label">Select From</label>
                        <input type="number" class="form-control" name="from" placeholder="From">
                    </div>
                    <div class="col-auto">
                        <label for="roleSelect" class="col-form-label">Select To</label>
                        <input type="number" class="form-control" name="to" placeholder="To">
                    </div>
                    <div class="col-auto mt-4">
                        <input type="submit" value="Assign" class="btn btn-success">
                    </div>
                </div>
            </div>

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
                        <th>Status</th>
                        <th>Response</th>
                        <th>Description</th>
                        <th>Last Call</th>
                        <th>Have to call</th>
                        <th>Count</th>
                        <th>QR</th>
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
                            <td>
                                <a href="tel:{{$number->phone_number}}">{{$number->phone_number}}</a>
                            </td>
                            <td>{{$number->city}}</td>
                            <td>
                                <select name="status" id="statusDropdown" onchange="updateStatus(this)">
                                    <option value="">Select Status</option>
                                    <option value="wrong number">Wrong Number</option>
                                    <option value="not interested">Not Interested</option>
                                    <option value="interested">Interested</option>
                                </select>
                            </td>
                            <td>{{$record?->status}}</td>
                            <td>{{$record?->description}}</td>
                            <td>{{$record?->created_at}}</td>
                            <td>{{$record?->have_to_call}}</td>
                            <td>{{$number->callRecords->count()}}</td>
                            <td>
                                <div class="qr-code" data-phone="{{$number->phone_number}}"></div>
                            </td>
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
{{--                                    <a href="tel:+91{{$number->phone_number}}" class="btn btn-warning" data-toggle="modal" data-target="#callModal" data-phone-number="{{$number->phone_number}}">Call</a>--}}
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
        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.qr-code').forEach(function(element) {
                var phoneNumber = element.getAttribute('data-phone');
                new QRCode(element, {
                    text: 'tel:' + phoneNumber,
                    width: 100,
                    height: 100
                });
            });
        });
    </script>

@endsection
