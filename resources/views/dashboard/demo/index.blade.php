@extends('dash_layouts.aap', ['title' => 'Demos'])
@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Form for setting instance and access -->
            <form action="{{ route('setInstanceAndAccess') }}" method="POST" class="row g-3">
                @csrf
                @php
                    $record = App\Models\UserInstanceAccess::where('user_id', auth()->user()->id)->first();
                @endphp
                <div class="col-md-6">
                    <input type="text" class="form-control" name="instance_id" value="{{ $record?->instance_id ?? '' }}"
                        placeholder="Instance Id">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="access_token"
                        value="{{ $record?->access_token ?? '' }}" placeholder="Access Token">
                </div>
                <div class="col-md-6 mt-2">
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </div>
                <div class="col-md-6 mt-2">
                    <a href="{{ route('clearInstanceAndAccess') }}" class="btn btn-danger w-100">Clear</a>
                </div>
            </form>

            <!-- Button for creating demo -->
            <div class="text-center mt-3">
                <a href="{{ route('demo.create') }}" class="btn btn-danger">Create Demo</a>
            </div>
        </div>
    </div>


    <div class="card" style="overflow-x: auto;">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-wrapper" style="overflow-x: auto;">
                    <table id="example1" class="table table-bordered table-striped text-xs w-100">
                        <thead class="title-name-header w-full">
                            <tr>
                                <th style="min-width: auto;">#</th>
                                <th style="min-width: auto;">Name</th>
                                <th style="min-width: auto;">City</th>
                                <th style="min-width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demoes as $demo)
                                <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">#: </span>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Name: </span>
                                        {{ $demo->name }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">City: </span>
                                        {{ $demo->city }}
                                    </td>
                                    <td class="d-block d-md-table-cell">
                                        <span class="font-weight-bold d-md-none">Action: </span>
                                        <div class="btn-group d-flex flex-column flex-md-row">
                                            @can('edit demo')
                                                <a href="{{ route('demo.edit', ['demo' => $demo->id]) }}"
                                                    class="btn btn-primary btn-sm mb-2 mb-md-0 mr-md-2">Edit</a>
                                            @endcan
                                            @can('delete demo')
                                                <a href="{{ route('demo.images', ['demo' => $demo]) }}"
                                                    class="btn btn-warning btn-sm">Images</a>
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
    
    <!-- /.card -->
@endsection
