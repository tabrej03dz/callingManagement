@extends('dash_layouts.aap', ['title' => 'Upload Numbers'])
@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{route('number.save')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputFile">Business Name</label>
                    <div class="input-group">
                        <input type="text" name="business_name" placeholder="Business Name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Mobile Number</label>
                    <div class="input-group">
                        <input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
                    </div>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <div class="input-group">
                        <input type="text" name="city" placeholder="City" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <div class="input-group">
                        <select name="status" id="" class="form-control">
                            <option value="">Select Status</option>
                            <option value="interested">Interested</option>
                            <option value="not interested">Not Interested</option>
                            <option value="wrong number">Wrong Number</option>
                            <option value="converted">Converted</option>
                        </select>
                    </div>
                </div>

                @role('super_admin|admin')
                    @php
                        $callingUsers = App\Models\User::role('calling team')->get();

                    @endphp
                <label for="user_i">User</label>
                <div class="input-group">
                    <select name="user_id" id="" class="form-control">
                        <option value="">Select User</option>
                        @foreach($callingUsers as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                @endrole

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
