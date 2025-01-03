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
            <form action="{{ route('number.index') }}" method="get" class="row gy-3 gx-4 align-items-end">
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                </div>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <label for="from" class="form-label">From</label>
                    <input type="date" class="form-control" id="from" name="from">
                </div>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <label for="to" class="form-label">To</label>
                    <input type="date" class="form-control" id="to" name="to">
                </div>
                <div class="col-12 col-lg-4 col-xl-6 d-flex gap-3 mt-3 mt-lg-0">
                    <button type="submit" class="btn btn-primary flex-grow-1 w-100 w-sm-auto">Apply</button>
                    <a href="{{ route('number.index') }}"
                        class="btn btn-outline-secondary flex-grow-1 w-100 w-sm-auto">Clear</a>
                </div>
            </form>

            @role('super_admin')
                <hr class="my-2">
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('number.allDelete') }}"
                        onclick="return confirm('Are you sure you want to delete all numbers?')"
                        class="btn btn-danger w-sm-auto w-lg-50">Delete All Numbers</a>
                    <a href="{{ route('number.unassignedDelete') }}" class="btn btn-danger w-sm-auto w-lg-50"
                        onclick="return confirm('Are you sure you want to delete all unassigned numbers?')">Delete Unassigned
                        Numbers</a>
                </div>
            @endrole
        </div>
    </div>




    <!-- /.card -->
    <div class="card">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <p>Assigned Numbers: {{ session('assignedCount') }}</p>
            </div>
        @endif
            @if(session('alreadyAssigned'))
                <div class="alert alert-warning">
                    Some numbers were already assigned.
                </div>
            @endif
        <form action="{{ route('number.assignToUser') }}" method="post">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with default features</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 align-items-end">
                        <div class="col">
                            <label for="userSelect" class="form-label">Select User</label>
                            <select class="form-control" id="userSelect" name="user_id">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="itemsInput" class="form-label">Items</label>
                            <input type="number" class="form-control" id="itemsInput" name="items" placeholder="Items">
                        </div>

                        @php
                            $records = App\Models\Number::select('city', DB::raw('count(*) as total'))
                                ->groupBy('city')
                                ->get();
                        @endphp

                        <div class="col">
                            <label for="citySelect" class="form-label">City</label>
                            <select name="city" class="form-control" id="citySelect">
                                <option value="">Choose City</option>
                                @foreach ($records as $record)
                                    <option value="{{ $record->city }}">{{ $record->city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-auto mt-2">
                            <input type="submit" value="Assign" class="btn btn-success w-100">
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form action="{{ route('number.checkedDelete') }}" method="POST">
            @csrf
            <div class="card-body">
                @role('super_admin|admin')
                    <div class="col-12 col-sm-6 col-lg-3 mb-3">
                        <input type="submit" value="Delete" class="btn btn-danger w-100">
                    </div>
                @endrole
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                @role('super_admin|admin')
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll">All</label>
                                        </div>
                                    </th>
                                @endrole
                                <th>Business Name</th>
                                <th>Owner Name</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Assigned User</th>
                                <th>Status</th>
                                {{--                    <th>CSS grade</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($numbers as $number)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                    <td>{{ $number->name }}</td>
                                    <td>{{ $number->phone_number }}</td>
                                    <td>{{ $number->city }}</td>
                                    <td>
                                        @foreach ($number->userNumbers as $user)
                                            {{ $user->user->name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $number->status }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
