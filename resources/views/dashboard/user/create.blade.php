@extends('dash_layouts.aap', ['title' => 'Create User'])
@section('content')
    <div class="card">
        <div class="card-body">
            <form role="form" action="{{route('user.store')}}" method="post" enctype="multipart/form-data" >
                @csrf
                <div class="form-group mb-3">
                    <input name="name" type="text" class="form-control" placeholder="Name" />
                </div>
                <div class="form-group mb-3">
                    <input name="email" type="email" class="form-control" placeholder="Email" />
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
