@extends('dash_layouts.aap', ['title' => 'Numbers'])
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('number.callBack') }}" method="get" class="form-inline">
{{--                @csrf--}}
                <div class="form-group mx-sm-2 mb-2">
                    <label for="from" class="sr-only">From</label>
                    <input type="date" class="form-control" id="from" name="from" placeholder="From">
                </div>
                <div class="form-group mx-sm-2 mb-2">
                    <label for="to" class="sr-only">To</label>
                    <input type="date" class="form-control" id="to" name="to" placeholder="To">
                </div>
                <button type="submit" class="btn btn-success mb-2">Filter</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
    {{--                        @role('super_admin|admin')--}}
    {{--                            <th>--}}
    {{--                                <div class="form-check">--}}
    {{--                                    <input class="form-check-input" type="checkbox" id="selectAll">--}}
    {{--                                    <label class="form-check-label" for="selectAll">All</label>--}}
    {{--                                </div>--}}
    {{--                            </th>--}}
    {{--                        @endrole--}}

                            <th>Business Name</th>
                            <th>Phone Number</th>
                            <th>City</th>
                            <th>Assigned User</th>
                            {{--                    <th>CSS grade</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentCalls as $call)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $call->number->business_name }}</td>
                                <td>{{ $call->number->phone_number }}</td>
                                <td>{{ $call->number->city }}</td>
                                <td>
                                    {{ $call->have_to_call }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column flex-md-row w-100">
                                        <a href="{{ route('callRecord.create', ['number' => $call->number->id]) }}"
                                            class="btn btn-warning btn-sm flex-fill mb-2 mb-md-0 mr-md-2">Response</a>
                                        <a href="{{ route('callRecord.markAsRecalled', ['record' => $call->id]) }}"
                                            class="btn btn-success btn-sm flex-fill mb-2 mb-md-0">Mark as Call</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showResponseModal(numberId) {
            $('#example1 tbody tr').removeClass('highlighted-row'); // Remove highlight from other rows
            $('#row-' + numberId).addClass('highlighted-row'); // Highlight the clicked row

            setTimeout(function() {
                $(`#responseModal${numberId}`).modal('show'); // Show the modal after 5 seconds
            }, 5000);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('autoResizeTextarea');

            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    </script>
@endsection
