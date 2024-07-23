@extends('dash_layouts.aap', ['title' => 'Demos'])
@section('content')

<div class="card" style="overflow-x: auto;">
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-wrapper" style="overflow-x: auto;">
                <table id="example1" class="table table-bordered table-striped text-xs w-100">
                    <thead class="title-name-header w-full">
                        <tr>
                            <th style="min-width: auto;">#</th>
                            <th style="min-width: auto;">Status</th>
                            <th style="min-width: auto;">Message</th>
                            <th style="min-width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                <td class="d-block d-md-table-cell">
                                    <span class="font-weight-bold d-md-none">#: </span>
                                    {{$loop->iteration}}
                                </td>
                                <td class="d-block d-md-table-cell">
                                    <span class="font-weight-bold d-md-none">Status: </span>
                                    {{$message->status}}
                                </td>
                                <td class="d-block d-md-table-cell">
                                    <span class="font-weight-bold d-md-none">Message: </span>
                                    {{$message->message}}
                                </td>
                                <td class="d-block d-md-table-cell">
                                    <span class="font-weight-bold d-md-none">Action: </span>
                                    <div class="btn-group d-flex flex-column flex-md-row">
                                        @can('show message')
                                            <a href="{{route('message.edit', ['message' => $message])}}" 
                                               class="btn btn-primary btn-sm mb-2 mb-md-0 mr-md-2">Edit</a>
                                        @endcan
                                        @can('edit message')
                                            <a href="{{route('message.delete', ['message' => $message])}}" 
                                               class="btn btn-warning btn-sm">Delete</a>
                                        @endcan
                                    </div>
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
