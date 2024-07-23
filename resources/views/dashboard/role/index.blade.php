@extends('dash_layouts.aap', ['title' => 'Roles'])
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-wrapper" style="overflow-x: auto;">
                            <table class="table table-bordered table-hover table-striped text-xs w-100">
                                <thead class="title-name-header w-full">
                                    <tr>
                                        <th style="min-width: 50px;">#</th>
                                        <th style="min-width: 150px;">Name</th>
                                        <th style="min-width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                                        <td class="d-block d-md-table-cell">
                                            <span class="font-weight-bold d-md-none">#: </span>
                                            {{$loop->iteration}}
                                        </td>
                                        <td class="d-block d-md-table-cell">
                                            <span class="font-weight-bold d-md-none">Name: </span>
                                            {{$role->name}}
                                        </td>
                                        <td class="d-block d-md-table-cell">
                                            <span class="font-weight-bold d-md-none">Action: </span>
                                            <div class="d-flex flex-column flex-md-row gap-2">
                                                <a href="{{route('role.delete', ['role' => $role])}}" class="btn btn-danger btn-sm mb-2 mb-md-0 w-100 w-md-auto">Delete</a>
                                                <a href="{{route('role.permission', ['role' => $role])}}" class="btn btn-warning btn-sm mb-2 mb-md-0 w-100 w-md-auto">Permission</a>
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