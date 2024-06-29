@extends('dash_layouts.aap', ['title' => 'Create Role'])
@section('content')
    <div class="card">
        <div class="card-body">
            <form role="form" action="{{route('role.store')}}" method="post" >
                @csrf
                <div class="form-group mb-3">
                    <input name="name" type="text" class="form-control" placeholder="Role Name" />
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
