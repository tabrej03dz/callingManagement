@extends('dash_layouts.aap', ['title' => $demo->name.' Images'])
@section('content')

    <style>
        .image-box {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
            overflow: hidden;
            text-align: center;
        }
        .image-box img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Images</h5>
                    <a href="{{ route('demo.addImage', ['demo' => $demo]) }}" class="btn btn-primary btn-sm">Add Image</a>
                </div>
                <div class="row">
                    <!-- Loop through your images here -->
                    @foreach($demo->images as $image)
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <div class="image-box">
                                <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid" alt="Image">
                                <a href="{{route('demo.imageDelete', ['image' => $image])}}" class="btn btn-danger btn-sm btn-block bg-transparent text-danger">Delete</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

@endsection
