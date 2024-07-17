@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <div class="card" style="overflow-x: auto;">
        <div class="card-header d-flex justify-content-between align-items-center flex-column flex-md-row">
            <form action="{{ route('number.assigned') }}" method="get" class="form-inline w-100 mb-2">
                <div class="form-group flex-grow-1 mr-2 mb-2 mb-md-0 w-100">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="form-control mr-2 mb-2 w-100">
                        <option value="">Select Status</option>
                        <option value="interested">Interested</option>
                        <option value="not interested">Not Interested</option>
                        <option value="wrong number">Wrong Number</option>
                        <option value="converted">Converted</option>
                    </select>
                    <input type="text" name="keyword" class="form-control mb-2 w-100" placeholder="Keywords">
                </div>
                <div class="d-flex flex-column flex-md-row w-100">
                    <button type="submit" class="btn btn-primary mb-2 mb-md-0 mr-md-2 w-100">Apply</button>
                    <a href="{{ route('number.assigned') }}" class="btn btn-secondary mb-2 mb-md-0 w-100">Clear</a>
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
                                <th style="min-width: 150px;">Name</th>
                                <th style="min-width: 150px;">Number</th>
                                <th style="min-width: 150px;">City</th>
                                <th style="min-width: 100px;">N/S</th>
                                <th style="min-width: 150px;">Response</th>
                                <th style="min-width: 200px;">Description</th>
                                <th style="min-width: 150px;">Last Call</th>
                                <th style="min-width: 150px;">Callback</th>
                                <th style="min-width: 100px;">Count</th>
                                @role('super_admin')
                                    <th style="min-width: 200px;">Assigned User</th>
                                @endrole
                                <th style="min-width: 150px;">Action</th>
                                <th style="min-width: 300px;">Demo</th> <!-- Adjusted min-width for Demo -->
                            </tr>
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
                                            <div class="btn-group">
                                                <select name="demo_id"
                                                    class="form-control form-control-sm mb-2 mb-md-0 w-100">
                                                    <option value="">Select Demo</option>
                                                    @foreach ($demos as $demo)
                                                        <option value="{{ $demo->id }}">
                                                            {{ $demo->name . ' - ' . $demo->city }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="custom_message"
                                                    class="form-control form-control-sm mb-2 mb-md-0 w-100"
                                                    placeholder="Custom Message">
                                                <button type="submit" class="btn btn-primary btn-sm">Send</button>
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
