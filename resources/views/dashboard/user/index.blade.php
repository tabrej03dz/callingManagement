{{-- @extends('dash_layouts.aap', ['title' => 'All Users'])
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
@endsection --}}

{{-- New Design --}}
@extends('dash_layouts.aap', ['title' => 'All Users'])

@section('content')
<div class="card shadow-lg rounded-lg overflow-hidden">
    <div class="card-header bg-primary text-white p-3">
        <h5 class="mb-0 font-weight-bold">All Users</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Instance & Access</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-bottom">
                        <td data-label="#" class="px-4 py-3">{{$loop->iteration}}</td>
                        <td data-label="Name" class="px-4 py-3">
                            <div class="d-flex flex-column">
                                <span class="font-weight-bold">{{$user->name}}</span>
                            </div>
                        </td>
                        <td data-label="Email" class="px-4 py-3">{{$user->email}}</td>
                        <td data-label="Role" class="px-4 py-3">
                            <span class="badge badge-info">{{$user->getRoleNames()}}</span>
                        </td>
                        <td data-label="Instance & Access" class="px-4 py-3">
                            <form action="{{ route('setInstanceAndAccess', ['user' => $user->id]) }}" method="POST" class="instance-access-form">
                                @csrf
                                <div class="form-container">
                                    <div class="form-group mb-2">
                                        <label for="access_token_{{$user->id}}" class="sr-only">Access Token</label>
                                        <input type="text" id="access_token_{{$user->id}}" name="access_token" class="form-control form-control-sm" placeholder="Access Token" value="{{ $user->instanceAccess?->access_token }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="instance_id_{{$user->id}}" class="sr-only">Instance ID</label>
                                        <input type="text" id="instance_id_{{$user->id}}" name="instance_id" class="form-control form-control-sm" placeholder="Instance Id" value="{{ $user->instanceAccess?->instance_id }}">
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <button type="submit" class="btn btn-success btn-sm w-100 mb-2">Save</button>
                                    <a href="{{ route('clearInstanceAndAccess', ['user' => $user->id]) }}" class="btn btn-secondary btn-sm w-100">Clear</a>
                                </div>
                            </form>
                        </td>
                        <td data-label="Action" class="px-4 py-3">
                            <div class="d-flex flex-column gap-2">
                                <a href="{{route('user.edit', ['user' => $user])}}" class="btn btn-sm btn-outline-primary w-100" aria-label="Edit user">
                                    <i class="fas fa-edit mr-1"></i><span>Edit</span>
                                </a>
                                <a href="{{route('user.delete', ['user' => $user])}}" class="btn btn-sm btn-outline-danger w-100" aria-label="Delete user">
                                    <i class="fas fa-trash mr-1"></i><span>Delete</span>
                                </a>
                                <a href="{{route('user.assignedNumbers', ['user' => $user])}}" class="btn btn-sm btn-outline-info w-100" aria-label="View assigned numbers">
                                    <i class="fas fa-list-ol mr-1"></i><span>Numbers</span>
                                </a>
                                <a href="{{route('user.permissions', ['user' => $user])}}" class="btn btn-sm btn-outline-secondary w-100" aria-label="Manage user permissions">
                                    <i class="fas fa-key mr-1"></i><span>Permissions</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table {
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .table tr {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .table tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }

    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    @media (max-width: 991.98px) {
        .table thead {
            display: none;
        }

        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .table td {
            padding: 1rem;
            text-align: left;
            position: relative;
            border-bottom: 1px solid #e9ecef;
        }

        .table td:last-child {
            border-bottom: none;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #6c757d;
            display: block;
            margin-bottom: 0.5rem;
        }

        .instance-access-form {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }

        .btn-sm {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .d-flex.flex-column {
            gap: 0.5rem !important;
        }
    }

    @media (min-width: 992px) {
        .table th:nth-child(1) { width: 5%; }
        .table th:nth-child(2) { width: 20%; }
        .table th:nth-child(3) { width: 20%; }
        .table th:nth-child(4) { width: 10%; }
        .table th:nth-child(5) { width: 25%; }
        .table th:nth-child(6) { width: 20%; }

        .instance-access-form {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .instance-access-form .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .instance-access-form .btn {
            white-space: nowrap;
        }
    }
</style>
@endsection