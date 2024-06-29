@extends('dash_layouts.aap', ['title' => 'Edit User'])
@section('content')
    <div class="card">
        <div class="card-body">
            <form role="form" action="{{route('user.update', ['user' => $user])}}" method="post" enctype="multipart/form-data" >
                @csrf
                <div class="form-group mb-3">
                    <input name="name" type="text" class="form-control" placeholder="Name" value="{{$user->name}}" />
                </div>
                <div class="form-group mb-3">
                    <input name="email" type="email" class="form-control" placeholder="Email" value="{{$user->email}}" />
                </div>
                <div class="form-group mb-3">
                    <select name="role_name" class="form-control custom-select">
                        <option value="">Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="form-group mb-3">
                    <input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password"/>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
