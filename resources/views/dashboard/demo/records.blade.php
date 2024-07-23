@extends('dash_layouts.aap', ['title' => 'Demo Records'])
@section('content')
    {{--    <div class="card"> --}}
    <div class="card-body">
        <form action="{{ route('demo.records') }}" method="GET">
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-4 mb-9 mb-md-2">
                    <label for="date" class="visually-hidden">Date</label>
                    <input type="date" class="form-control mb-2 mb-md-0" id="date" name="date" placeholder="Date">
                </div>
                <div class="col-12 col-md-4 mt-md-4">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-12 col-md-4 mt-3 mt-md-4">
                    <a href="{{ route('demo.records') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </div>
        </form>
    </div>
    {{--    </div> --}}


    <div class="card" style="overflow-x: auto;">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">#</th>
                                <th style="min-width: auto;">Name</th>
                                <th style="min-width: auto;">Number</th>
                                <th style="min-width: auto;">Demo Name</th>
                                <th style="min-width: auto;">Custom Message</th>
                                <th style="min-width: auto;">Sent By</th>
                                <th style="min-width: auto;">Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demoRecords as $record)
                                <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">#: </span>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Name: </span>
                                        {{ $record->number->business_name }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Number: </span>
                                        {{ $record->number->phone_number }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Demo Name: </span>
                                        {{ $record->demo?->name }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Custom Message: </span>
                                        {!! $record->custom_message !!}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Sent By: </span>
                                        {{ $record->user->name }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Sent At: </span>
                                        {{ $record->created_at->format('D-m h:i') }}
                                    </td>
                                </tr>
                            @endforeach
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
        }
    </style>

    <!-- /.card -->
@endsection
