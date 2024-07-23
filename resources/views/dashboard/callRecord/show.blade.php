@extends('dash_layouts.aap', ['title' => 'Call Records'])
@section('content')
    <div class="card" style="overflow-x: auto;">
        <div class="card-header d-flex justify-content-between align-items-center flex-column flex-md-row">
            <h3 class="card-title">Call Records</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">Status</th>
                                <th style="min-width: auto;">Description</th>
                                <th style="min-width: auto;">Called At</th>
                                <th style="min-width: auto;">Have to call</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                                <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Status: </span>
                                        {{ $record->status }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Description: </span>
                                        {{ $record->description }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Called At: </span>
                                        {{ $record->created_at }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Have to call: </span>
                                        {{ $record->have_to_call }}
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
@endsection