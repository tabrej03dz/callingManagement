@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- /.card -->
    <div class="card" style="overflow-x: auto;">
        <div class="card-header d-flex justify-content-between align-items-center">
{{--            <h3 class="card-title">DataTable with default features</h3>--}}
            <a href="{{route('number.add')}}" class="btn btn-primary ml-auto">Add Number</a>
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
        @php
            function getStatusClass($status) {
                switch ($status) {
                    case 'call pick':
                        return 'bg-success';
                    case 'call not pick':
                        return 'bg-danger';
                    case 'call back':
                        return 'bg-primary';
                    case 'interested':
                        return 'bg-success';
                    case 'not interested':
                        return 'bg-danger';
                    case 'wrong number':
                        return 'bg-warning';
                    default:
                        return '';
                }
            }
        @endphp

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
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
                    <th>N/S</th>
                    <th>Response</th>
                    <th>Description</th>
                    <th>Last Call</th>
                    <th>Have to call</th>
                    <th>Count</th>
                    @role('super_admin')
                    <th>Assigned User</th>
                    @endrole
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($numbers as $number)
                    @php
                        $record = $number->callRecords()->latest()->first();
                        // Debug: Output the status to the console or page
                        echo "<script>console.log('Status: " . $record?->status . "');</script>";
                    @endphp
                    <tr class="{{ getStatusClass($record?->status) }}">
                        @role('super_admin|admin')
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" name="numbers[]" value="{{$number->id}}" type="checkbox" id="{{$number->id}}">
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

                        <td class="{{ getStatusClass($number?->status) }}">
                            {{$number->status}}
                        </td>
                        <td>
                            {{$record?->status}}
                        </td>
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
                                <a href="{{route('callRecord.create', ['number' => $number->id])}}" class="btn btn-warning">Create Response</a>
                                <a href="{{route('callRecord.show', ['number' => $number->id])}}" class="btn btn-primary">Call Records</a>
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


{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const selectAllCheckbox = document.getElementById('selectAll');--}}
{{--            const checkboxes = document.querySelectorAll('input[name="numbers[]"]');--}}

{{--            selectAllCheckbox.addEventListener('change', function () {--}}
{{--                checkboxes.forEach(checkbox => {--}}
{{--                    checkbox.checked = selectAllCheckbox.checked;--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        {{--function updateStatus(select) {--}}
        {{--    var status = select.value;--}}
        {{--    var numberId = {{ $number->id }}; // Replace this with the appropriate variable to get the number ID--}}
        {{--    if (status) {--}}
        {{--        var url = "{{ route('number.status', ['number' => ':number', 'status' => ':status']) }}";--}}
        {{--        url = url.replace(':number', numberId).replace(':status', status);--}}
        {{--        window.location.href = url;--}}
        {{--    }--}}
        {{--}--}}

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
