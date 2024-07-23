@extends('dash_layouts.aap', ['title' => 'All Users'])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-wrapper" style="overflow-x: auto;">
                <table class="table table-bordered table-striped text-xs w-100">
                    <thead class="title-name-header w-full">
                        <tr>
                            <th style="min-width: 50px;">#</th>
                            <th style="min-width: 150px;">Name</th>
                            <th style="min-width: 200px;">Email</th>
                            <th style="min-width: 100px;">Role</th>
                            <th style="min-width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="d-md-table-row d-flex flex-column mb-4 p-3 bg-white rounded shadow-sm">
                            <td class="d-block d-md-table-cell">
                                <span class="font-weight-bold d-md-none">#: </span>
                                {{$loop->iteration}}
                            </td>
                            <td class="d-block d-md-table-cell">
                                <span class="font-weight-bold d-md-none">Name: </span>
                                {{$user->name}}
                            </td>
                            <td class="d-block d-md-table-cell">
                                <span class="font-weight-bold d-md-none">Email: </span>
                                {{$user->email}}
                            </td>
                            <td class="d-block d-md-table-cell">
                                <span class="font-weight-bold d-md-none">Role: </span>
                                {{$user->getRoleNames()}}
                            </td>
                            <td class="d-block d-md-table-cell">
                                <span class="font-weight-bold d-md-none">Action: </span>
                                <div class="d-flex flex-column flex-md-row gap-2">
                                    <a href="{{route('user.edit', ['user' => $user])}}" class="btn btn-primary btn-sm mb-2 mb-md-0 w-100 w-md-auto">Edit</a>
                                    <a href="{{route('user.delete', ['user' => $user])}}" class="btn btn-danger btn-sm mb-2 mb-md-0 w-100 w-md-auto">Delete</a>
                                    <a href="{{route('user.assignedNumbers', ['user' => $user])}}" class="btn btn-info btn-sm mb-2 mb-md-0 w-100 w-md-auto">Assigned Numbers</a>
                                    <a href="{{route('user.permissions', ['user' => $user])}}" class="btn btn-secondary btn-sm mb-2 mb-md-0 w-100 w-md-auto">Permissions</a>
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