@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <div class="card" style="overflow-x: auto;">
        <div class="card-header d-flex justify-content-between align-items-center flex-column flex-md-row">
            <form action="{{ route('number.assigned') }}" method="get" class="form-inline w-100 mb-2">
                <div class="row w-100">
                    <div class="form-group col-md-6 col-lg-4 mb-2">
                        <label for="status" class="sr-only">Status</label>
                        <select name="status" id="status" class="form-control w-100">
                            <option value="">Select Status</option>
                            <option value="interested">Interested</option>
                            <option value="not interested">Not Interested</option>
                            <option value="wrong number">Wrong Number</option>
                            <option value="converted">Converted</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-lg-3 mb-2">
                        <input type="text" name="city" class="form-control w-100" placeholder="City">
                    </div>
                    <div class="form-group col-md-6 col-lg-3 mb-2">
                        <input type="text" name="keyword" class="form-control w-100" placeholder="Keywords">
                    </div>
                    <div class="col-md-6 col-lg-2 d-flex mb-2">
                        <button type="submit" class="btn btn-primary w-100 mr-2">Apply</button>
                        <a href="{{ route('number.assigned') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>

            <div class="w-100 text-right text-center text-md-right">
                <a href="{{ route('number.add') }}" class="btn btn-primary ml-2 mb-2">Add Number</a>
            </div>
        </div>

        @php
            function getStatusClass($status)
            {
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
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">Name</th>
                                <th style="min-width: auto;">Number</th>
                                <th style="min-width: auto;">City</th>
                                <th style="min-width: auto;">N/S</th>
                                <th style="min-width: auto;">Response</th>
                                <th style="min-width: auto;">Description</th>
                                <th style="min-width: 100px;">Last Call</th>
                                <th style="min-width: auto;">Callback</th>
                                <th style="min-width: auto;">Count</th>
                                @role('super_admin')
                                    <th style="min-width: auto;">Assigned User</th>
                                @endrole
                                <th style="min-width: 150px;">Action</th>
                                <th style="min-width: 300px;">Demo</th>
                        </thead>
                        <tbody>
                            @foreach ($numbers as $number)
                                @php
                                    $record = $number->callRecords()->latest()->first();
                                @endphp
                                <tr id="row-{{ $number->id }}"
                                    class="{{ getStatusClass($record?->status) }} d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Name: </span>
                                        <label class="form-check-label"
                                            for="{{ $number->id }}">{{ $number->business_name }}</label>
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Number: </span>
{{--                                        <a href="tel:{{ $number->phone_number }}" onclick="showResponseModal('{{ $number->id }}')">{{ $number->phone_number }}</a>--}}
                                        <a href="tel:{{ $number->phone_number }}">{{ $number->phone_number }}</a>
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">City: </span>
                                        {{ $number->city }}
                                    </td>
                                    <td class="d-block d-md-table-cell {{ getStatusClass($number?->status) }}">
                                        <span class="font-weight-bold d-md-none">N/S: </span>
                                        {{ $number?->status }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Response: </span>
                                        {{ $record?->status }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Description: </span>
                                        {{ $record?->description }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Last Call: </span>
                                        {{ $record?->created_at->format('d-M h:i') }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Callback: </span>
                                        {{ $record?->have_to_call?->format('d-M h:i') }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Count: </span>
                                        {{ $number->callRecords->count() }}
                                    </td>
                                    @role('super_admin|admin')
                                        <td class="d-block d-md-table-cell">
                                            <span class="font-weight-bold d-md-none">Assigned User: </span>
                                            <ul style="list-style: none; padding: 0;">
                                                @foreach ($number->userNumbers as $user)
                                                    <li>{{ $user->user->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    @endrole
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Action: </span>
                                        <div class="btn-group d-flex flex-column flex-md-row ml-10">
                                            {{-- <a href="#" data-toggle="modal" data-target="#responseModal"
                                                class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2">Response</a> --}}

                                            <a href="{{ route('callRecord.create', ['number' => $number->id]) }}"
                                               class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2">Response</a>
                                            <a href="{{ route('callRecord.show', ['number' => $number->id]) }}"
                                                class="btn btn-primary btn-sm">Records</a>
                                        </div>
                                    </td>
                                    <td class="d-block d-md-table-cell" style="min-width: 300px;">
                                        <!-- Adjusted min-width for Demo -->
                                        <span class="font-weight-bold d-md-none">Demo: </span>
                                        <form action="{{ route('demo.send', ['number' => $number->id]) }}"
                                            class="form-inline" method="post">
                                            @csrf
                                            <div class="btn-group w-100">
                                                <div class="d-flex flex-column flex-md-row w-100 align-items-center">
                                                    <select name="demo_id"
                                                        class="form-control form-control-sm mb-2 mb-md-0 mr-md-2 w-32 h-12">
                                                        <option value="">Select Demo</option>
                                                        @foreach ($demos as $demo)
                                                            <option value="{{ $demo->id }}">
                                                                {{ $demo->name . ' - ' . $demo->city }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <textarea id="autoResizeTextarea" name="custom_message" class="form-control form-control-sm mb-2 mb-md-0 mr-md-2 flex-grow-1 w-32" placeholder="Custom Message"></textarea>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm lg:w-32 md:w-32 h-12 mt-2 mt-md-0 px-3">Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Response Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" action="{{ route('callRecord.store', ['number' => $number->id]) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <select name="status" class="form-control custom-select">
                                <option value="">Response</option>
                                <option value="call pick" {{ old('status') == 'call pick' ? 'selected' : '' }}>Call Pick
                                </option>
                                <option value="call not pick" {{ old('status') == 'call not pick' ? 'selected' : '' }}>
                                    Call Not Pick</option>
                                <option value="call back" {{ old('status') == 'call back' ? 'selected' : '' }}>Call Back
                                </option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select name="number_status" class="form-control custom-select">
                                <option value="">Number Status</option>
                                <option value="interested" {{ old('number_status') == 'interested' ? 'selected' : '' }}>
                                    Interested</option>
                                <option value="not interested"
                                    {{ old('number_status') == 'not interested' ? 'selected' : '' }}>Not Interested
                                </option>
                                <option value="wrong number"
                                    {{ old('number_status') == 'wrong number' ? 'selected' : '' }}>Wrong Number</option>
                                <option value="converted" {{ old('number_status') == 'converted' ? 'selected' : '' }}>
                                    Converted</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                placeholder="Description" style="resize: none;">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Call back time</label>
                            <input name="date_and_time" type="datetime-local" class="form-control"
                                placeholder="Have to call" value="{{ old('date_and_time') }}" />
                        </div>

                        <div class="form-group mb-3">
                            <input name="send_message" id="send_message" type="checkbox" value="true" />
                            <label for="send_message">Do you want to send message to this number</label>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <style>
        .highlighted-row {
            background-color: #ffffcc !important; /* Adjust as needed */
        }
    </style>
    <script>
        function showResponseModal(numberId) {
            console.log('Number ID:', numberId);
            $('#example1 tbody tr').removeClass('highlighted-row'); // Remove highlight from other rows
            $('#row-' + numberId).addClass('highlighted-row'); // Highlight the clicked row

            setTimeout(function() {
                console.log('Showing modal now');
                $('#responseModal').modal('show'); // Show the modal after 5 seconds
            }, 5000);
        }
        document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('autoResizeTextarea');
    
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});

    </script>

{{--    <script>--}}
{{--        function showResponseModal(numberId) {--}}
{{--            setTimeout(function() {--}}
{{--                $('#responseModal').modal('show');--}}
{{--            }, 5000); // 5000 milliseconds = 5 seconds--}}
{{--        }--}}
{{--    </script>--}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                const checkboxes = document.querySelectorAll('input[name="numbers[]"]');

                selectAllCheckbox.addEventListener('change', function() {
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

            console.log('URL Parameters:', params.toString());
            console.log('Saved Number ID:', savedNumberId);

            if (savedNumberId) {
                const row = document.getElementById(`row-${savedNumberId}`);
                console.log('Row Element:', row);

                if (row) {
                    console.log('Viewport Height:', window.innerHeight);
                    console.log('Row Offset Top:', row.offsetTop);
                    row.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    row.classList.add('highlight');

                    setTimeout(() => {
                        row.style.backgroundColor = 'yellow';
                        setTimeout(() => {
                            row.style.backgroundColor = '';
                        }, 2000);
                    }, 500);
                } else {
                    console.log('Row not found');
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
            from {
                background-color: yellow;
            }

            to {
                background-color: transparent;
            }
        }

        @media (max-width: 768px) {
            .title-name-header {
                display: none;
            }
        }
    </style>
@endsection
