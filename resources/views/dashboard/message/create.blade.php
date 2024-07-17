@extends('dash_layouts.aap', ['title' => 'Create Demo'])
@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Message</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{route('message.store')}}" method="post" >
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputFile">Status</label>
                    <div class="input-group">
                        <select name="status" id="" class="form-control">
                            <option value="">Select Status</option>
                            <option value="interested">Interested<option>
                            <option value="not interested">Not Interested<option>
                            <option value="wrong number">Wrong Number<option>
                            <option value="converted">Converted<option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Message</label>
                    <div class="input-group">
                        <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
