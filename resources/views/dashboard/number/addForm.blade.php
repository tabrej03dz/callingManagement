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
                        <div class="custom-file">
                            <input type="text" name="business_name" class="custom-file-input">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Mobile Number</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="mobile_number" class="custom-file-input">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">City</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="text" name="city" class="custom-file-input">
                        </div>
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
