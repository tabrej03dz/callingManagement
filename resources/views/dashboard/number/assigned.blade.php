@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')
{{--    <style>--}}
{{--        td{--}}
{{--            padding: 5px!important;--}}
{{--        }--}}
{{--    </style>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>--}}
    <div class="card" style="overflow-x: auto;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form action="{{ route('number.assigned') }}" method="get" class="form-inline">
                <div class="form-group mb-2">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="interested">Interested</option>
                        <option value="not interested">Not Interested</option>
                        <option value="wrong number">Wrong Number</option>
                        <option value="converted">Converted</option>
                    </select>
                    <input type="text" name="keyword" class="form-control" placeholder="Keywords">
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-2">Apply</button>
            </form>
            <a href="{{route('number.assigned')}}" class="btn btn-secondary mb-2 ml-2">Clear</a>
            <a href="{{ route('number.add') }}" class="btn btn-primary ml-auto">Add Number</a>
        </div>

        @php
            function getStatusClass($status) {
                switch ($status) {
                    case 'call pick':
                        return '';
                    case 'call not pick':
                        return 'bg-warning';
                    case 'call back':
                        return 'bg-dark';
                    case 'interested':
                        return 'bg-primary';
                    case 'not interested':
                        return 'bg-danger';
                    case 'wrong number':
                        return '';
                    default:
                        return '';
                }
            }
        @endphp

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped text-xs">
                <thead>
                <tr>
{{--                    @role('super_admin|admin')--}}
{{--                    <th>--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="selectAll">--}}
{{--                            <label class="form-check-label" for="selectAll">All</label>--}}
{{--                        </div>--}}
{{--                    </th>--}}
{{--                    @endrole--}}
                    <th>Name</th>
                    <th>Number</th>
                    <th>City</th>
                    <th>N/S</th>
                    <th>Response</th>
                    <th>Description</th>
                    <th>Last Call</th>
                    <th>callback</th>
                    <th>Count</th>
                    @role('super_admin')
                    <th>Assigned User</th>
                    @endrole
                    <th>Action</th>
                    <th>Demo</th>
                </tr>
                </thead>
                <tbody>
                @foreach($numbers as $number)
                    @php
                        $record = $number->callRecords()->latest()->first();
                    @endphp
                    <tr id="row-{{$number->id}}" class="{{ getStatusClass($record?->status) }}">
{{--                        @role('super_admin|admin')--}}
{{--                        <td>--}}
{{--                            <div class="form-check">--}}
{{--                                <input class="form-check-input" name="numbers[]" value="{{$number->id}}" type="checkbox" id="{{$number->id}}">--}}
{{--                                <label class="form-check-label"></label>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        @endrole--}}

                        <td>
                            <label class="form-check-label" for="{{$number->id}}">{{$number->business_name}}</label>
                        </td>
                        <td>
                            <a href="tel:{{$number->phone_number}}">{{$number->phone_number}}</a>
                        </td>
                        <td>{{$number->city}}</td>
                        <td class="{{ getStatusClass($number?->status) }}">

                            {{$number?->status}}
                        </td>
                        <td>
                            {{$record?->status}}
                        </td>
                        <td>{{$record?->description}}</td>
                        <td>{{$record?->created_at->format('d-M h:i')}}</td>
                        <td>{{ $record?->have_to_call?->format('d-M h:i')}}</td>
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
                                <a href="{{route('callRecord.create', ['number' => $number->id])}}" class="btn btn-warning btn-xs">Response</a>
                                <a href="{{route('callRecord.show', ['number' => $number->id])}}" class="btn btn-primary btn-xs">Records</a>
                            </div>
                        </td>
                        <td>
                            <form action="{{route('demo.send', ['number' => $number->id])}}" class="form-inline" method="post">
                                @csrf
                                <div class="btn-group">
                                    <select name="demo_id" class="form-control form-control-sm" id="">
                                        <option value="">Select Demo</option>
                                        @foreach($demos as $demo)
                                            <option value="{{$demo->id}}">{{$demo->name.' - '.$demo->city}}</option>
                                        @endforeach
                                    </select>
                                    <textarea name="custom_message" id="" class="form-control form-control-sm" cols="30" ></textarea>
{{--                                    <input type="text" name="custom_message" class="form-control form-control-sm" placeholder="Custom Message">--}}
                                    <button type="submit" class="btn btn-primary btn-xs">Send</button>
                                </div>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                const checkboxes = document.querySelectorAll('input[name="numbers[]"]');

                selectAllCheckbox.addEventListener('change', function () {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });
            }

            document.querySelectorAll('.qr-code').forEach(function(element) {
                var phoneNumber = element.getAttribute('data-phone');
                new QRCode(element, {
                    text: 'tel:' + phoneNumber,
                    width: 100,
                    height: 100
                });
            });

            const params = new URLSearchParams(window.location.search);
            const savedNumberId = params.get('saved_number_id');

            console.log('URL Parameters:', params.toString()); // Debugging log
            console.log('Saved Number ID:', savedNumberId); // Debugging log

            if (savedNumberId) {
                const row = document.getElementById(`row-${savedNumberId}`);
                console.log('Row Element:', row); // Debugging log

                if (row) {
                    console.log('Viewport Height:', window.innerHeight); // Debugging log
                    console.log('Row Offset Top:', row.offsetTop); // Debugging log
                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    row.classList.add('highlight'); // Add a highlight class for visual feedback (optional)

                    // Fallback for Chrome
                    setTimeout(() => {
                        row.style.backgroundColor = 'yellow';
                        setTimeout(() => {
                            row.style.backgroundColor = '';
                        }, 2000);
                    }, 500);
                } else {
                    console.log('Row not found'); // Debugging log
                }
            }
        });
    </script>

    <style>
        .highlight {
            background-color: yellow;
            animation: highlightAnimation 2s ease-in-out;
        }
        @keyframes highlightAnimation {
            from { background-color: yellow; }
            to { background-color: transparent; }
        }
    </style>
@endsection
