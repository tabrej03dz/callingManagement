@extends('dash_layouts.aap', ['title' => 'Numbers'])
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    @if (session()->has('alreadyAssigned') && session('alreadyAssigned'))
        <div class="card">
            <div class="card-head">
                <h6 class="ml-4 mt-3 mb-0">These numbers had been assigned to another user</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <form action="{{ route('number.unAssign') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Assigned Numbers</th>
                                        <th scope="col">Assigned User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('alreadyAssigned') as $assigned)
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <input type="checkbox" name="alreadyAssignedNumbers[]" hidden checked
                                                    value="{{ $assigned->id }}" class="mr-2">
                                                <span>{{ $assigned->number->phone_number }}</span>
                                            </td>
                                            <td>
                                                @foreach ($assigned->number->userNumbers as $userNumber)
                                                    <span>Name: {{ $userNumber->user?->name }}, Assigned At:
                                                        {{ $userNumber->assigned_at }}, Assigned By:
                                                        {{ $userNumber->assignedBy?->name }}</span>
                                                    <br>
                                                @endforeach

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger mr-2" value="Cancel">
                            <a href="{{ route('number.index') }}" class="btn btn-success">Yes! Keep It</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('number.index') }}" method="get">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-sm-6 col-md-3 mb-md-2">
                        <label for="city" class="visually-hidden">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mb-md-2">
                        <label for="date" class="visually-hidden">Date</label>
                        <input type="date" class="form-control" id="date" name="date" placeholder="Date">
                    </div>
                    <div class="col-6 col-md-3 mt-4">
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </div>
                    <div class="col-6 col-md-3 mt-4">
                        <a href="{{ route('number.index') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <!-- /.card -->
    <div class="card">

        <form action="{{ route('number.assignToUser') }}" method="post">
            @csrf
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row align-items-center">
                    <div class="col-12 col-sm-auto">
                        <label for="userSelect" class="col-form-label">Select User</label>
                        <select class="form-control" id="userSelect" name="user_id">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{--                    <div class="col-auto"> --}}
                    {{--                        <label for="roleSelect" class="col-form-label">Select From</label> --}}
                    {{--                        <input type="number" class="form-control" name="from" placeholder="From"> --}}
                    {{--                    </div> --}}
                    {{--                    <div class="col-auto"> --}}
                    {{--                        <label for="roleSelect" class="col-form-label">Select To</label> --}}
                    {{--                        <input type="number" class="form-control" name="to" placeholder="To"> --}}
                    {{--                    </div> --}}

                    <div class="col-12 col-sm-auto">
                        <label for="itemsInput" class="col-form-label">Items</label>
                        <input type="number" id="itemsInput" class="form-control w-100 w-sm-auto" name="items"
                            placeholder="Items">
                    </div>

                    @php
                        //$subQuery = App\Models\Number::select('id')
                        //    ->whereIn('id', function ($query) {
                        //        $query->select(\DB::raw('MIN(id)'))
                        //              ->from('numbers')
                        //              ->groupBy('city');
                        //    });

                        //$records = App\Models\Number::whereIn('id', $subQuery)->get();
                        $records = App\Models\Number::select('city', DB::raw('count(*) as total'))
                            ->groupBy('city')
                            ->get();
                    @endphp

                    <div class="col-12 col-sm-auto">
                        <label for="citySelect" class="col-form-label">City</label>
                        <select name="city" class="form-control w-100 w-sm-auto" id="citySelect">
                            <option value="">Choose City</option>
                            @foreach ($records as $record)
                                <option value="{{ $record->city }}">{{ $record->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-auto mt-9">
                        <input type="submit" value="Assign" class="btn btn-success w-100 w-sm-auto">
                    </div>
                </div>
            </div>

        </form>
        <form action="{{ route('number.checkedDelete') }}" method="POST">
            @csrf
            <div class="card-body">
                <input type="submit" value="Delete" class="btn btn-danger col-12 col-sm-auto mb-4"
                    aria-label="Delete item">
                <div class="table-responsive">
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
                            @foreach ($numbers as $number)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="numbers[]" value="{{ $number->id }}"
                                                type="checkbox" id="{{ $number->id }}">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="form-check-label"
                                            for="{{ $number->id }}">{{ $number->business_name }}</label>
                                    </td>
                                    <td>{{ $number->phone_number }}</td>
                                    <td>{{ $number->city }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </form>
        {{ $numbers->links() }}
    </div>
    <!-- /.card -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="numbers[]"]');

            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });
    </script>
@endsection
