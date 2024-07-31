@extends('dash_layouts.aap', ['title' => 'All Users'])
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-wrapper" style="overflow-x: auto;">
                <table class="table table-bordered table-striped text-xs w-100">
                    <thead class="title-name-header w-full">
                        <tr>
                            <th >#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Instance & Access</th>
                            <th>Action</th>
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
                                <span class="font-weight-bold d-md-none">Instance & Access: </span>
                                <form action="{{ route('setInstanceAndAccess', ['user' => $user->id]) }}" method="POST" class="form-inline">
                                    @csrf
                                    <div class="form-group mx-2">
                                        <input type="text" name="instance_id" class="form-control form-control-sm" placeholder="Instance Id" value="{{ $user->instanceAccess?->instance_id }}">
                                    </div>
                                    <div class="form-group mx-2">
                                        <input type="text" name="access_token" class="form-control form-control-sm" placeholder="Access Token" value="{{ $user->instanceAccess?->access_token }}">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm mx-2">Save</button>
                                    <a href="{{ route('clearInstanceAndAccess', ['user' => $user->id]) }}" class="btn btn-secondary btn-sm">Clear</a>
                                </form>

                            </td>
                            <td class="d-block d-md-table-cell">
                                <span class="font-weight-bold d-md-none">Action: </span>
                                <div class="d-flex btn-group flex-column flex-md-row gap-2">
                                    <a href="{{route('user.edit', ['user' => $user])}}" class="btn btn-primary btn-sm ">Edit</a>
                                    <a href="{{route('user.delete', ['user' => $user])}}" class="btn btn-danger btn-sm ">Delete</a>
                                    <a href="{{route('user.assignedNumbers', ['user' => $user])}}" class="btn btn-info btn-sm ">Assigned Numbers</a>
                                    <a href="{{route('user.permissions', ['user' => $user])}}" class="btn btn-secondary btn-sm ">Permissions</a>
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
