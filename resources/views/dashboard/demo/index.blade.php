@extends('dash_layouts.aap', ['title' => 'Demos'])
@section('content')

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>City</th>
                        {{--                    <th>CSS grade</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($demoes as $demo)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$demo->name}}</td>
                            <td>{{$demo->city}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
