@extends('dash_layouts.aap', ['title' => 'Numbers'])
@section('content')

    <!-- /.card -->
    <div class="card">
        <form action="{{route('number.assignToUser')}}" method="post">
            @csrf
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="userSelect" class="col-form-label">Select User</label>
                        <select class="form-control" id="userSelect" name="user_id">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="roleSelect" class="col-form-label">Item number</label>
                        <input type="number" class="form-control" name="items">
                    </div>
                    <div class="col-auto mt-4">
                        <input type="submit" value="Assign" class="btn btn-success">
                    </div>
                </div>
            </div>


            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">All</label>
                            </div>
                        </th>
                        <th>Business Name</th>
                        <th>Phone Number</th>
                        <th>City</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($numbers as $number)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" name="numbers[]" value="{{$number->id}}" type="checkbox" id="{{$number->id}}" >
                                    <label class="form-check-label"></label>
                                </div>
                            </td>
                            <td>
                                <label class="form-check-label" for="{{$number->id}}">{{$number->business_name}}</label>
                            </td>
                            <td>{{$number->phone_number}}</td>
                            <td>{{$number->city}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
    <!-- /.card -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="numbers[]"]');

            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });
    </script>
@endsection
