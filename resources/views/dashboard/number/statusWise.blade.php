@extends('dash_layouts.aap', ['title' => ($status ?? 'All') . ' Numbers'])
@section('content')

    <div class="card" style="overflow-x: auto;">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">Business Name</th>
                                <th style="min-width: auto;">Phone Number</th>
                                <th style="min-width: auto;">City</th>
                                <th style="min-width: auto;">Msg</th>
                                <th style="min-width: auto;">Date & Time</th>
                                <th style="min-width: auto;">Assigned User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($numbers as $number)
                                <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Business Name: </span>
                                        {{ $number->business_name }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Phone Number: </span>
                                        <a href="tel:{{ $number->phone_number }}">{{ $number->phone_number }}</a>
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">City: </span>
                                        {{ $number->city }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Msg: </span>
                                        {{ $number->callRecords()->latest()->first()?->description ?? 'N/A' }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Date & Time: </span>
                                        @php
                                            $latestCallRecord = $number->callRecords()->latest()->first();
                                        @endphp
                                        {{ $latestCallRecord ? $latestCallRecord->created_at->format('d-M-Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Assigned User: </span>
                                        @forelse($number->userNumbers as $user)
                                            {{ $user->user->name }}{{ !$loop->last ? ', ' : '' }}
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No numbers found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .title-name-header {
                display: none;
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, .05);
            }

            .d-md-table-cell {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }
        }
    </style>

@endsection
