@extends('dash_layouts.aap', ['title' => 'Assigned Numbers'])
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div id="preloader">
        <div class="d-flex justify-content-center">
            <div class="spinner-grow text-primary m-2" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary m-2" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-success m-2" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <p class="mt-3">Loading, please wait...</p>
    </div>
    <div class="card" style="overflow-x: auto;">
        <div class="card-header d-flex justify-content-between align-items-center flex-column flex-md-row">
            <form action="{{ route('number.assigned') }}" method="get" class="form-inline w-100 mb-2">
                <div class="row w-100">
                    <div class="form-group col-md-6 col-lg-4 mb-2">
                        <label for="status" class="sr-only">Status</label>
                        <select name="status" id="status" class="form-control w-100">
                            <option value="">Select Status</option>
                            <option value="interested">Interested</option>
                            <option value="not interested">Not Interested</option>
                            <option value="wrong number">Wrong Number</option>
                            <option value="converted">Converted</option>
                            <option value="not call">Not call</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-lg-3 mb-2">
                        <input type="text" name="city" class="form-control w-100" placeholder="City">
                    </div>
                    <div class="form-group col-md-6 col-lg-3 mb-2">
                        <input type="text" name="keyword" class="form-control w-100" placeholder="Keywords">
                    </div>
                    <div class="col-md-6 col-lg-2 d-flex mb-2">
                        <button type="submit" class="btn btn-primary w-100 mr-2">Apply</button>
                        <a href="{{ route('number.assigned') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>

            @php
                if (auth()->user()->hasRole('super_admin|admin')){
                $lastCall = \App\Models\Number::whereHas('callRecords')->orderBy('updated_at', 'desc')->first();
                }else{
                    $numberIds = \App\Models\UserNumber::where('user_id', auth()->user()->id)->pluck('number_id');
                    $lastCall = \App\Models\Number::whereIn('id', $numberIds)
                                  ->whereHas('callRecords')
                                  ->orderBy('updated_at', 'desc')
                                  ->first();
                }

            @endphp
            <div class="w-100 text-right text-center text-md-right">
                <a href="{{ route('number.add') }}" class="btn btn-primary ml-2 mb-2">Add Number</a>
                <a href="#lastCall" class="btn btn-warning ml-2 mb-2">Last Call</a>
            </div>
        </div>

        @php
            function getStatusClass($status)
            {
                switch ($status) {
                    case 'call pick':
                        return '';
                    case 'call not pick':
                        return 'bg-warning';
                    case 'call back':
                        return 'blue';
                    case 'interested':
                        return 'green';
                    case 'not interested':
                        return 'red';
                    case 'wrong number':
                        return 'black';
                    default:
                        return '';
                }
            }
        @endphp

        <div class="card-body">
            <div class="contact-list">
                @foreach ($allNumbers as $number)
                    @php
                        if ($number->callRecords->count() > 0) {
                            continue;
                        }
                        $record = $number->callRecords()->latest()->first();
                    @endphp
                    <div class="card mb-4 shadow-lg rounded-lg overflow-hidden border border-light">
                        <div class="card-header bg-primary text-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 font-weight-bold text-truncate">{{ $number->business_name }}</h5>
                                <span class="badge badge-light badge-pill" id="lastCall{{$number->id}}">
                                    {{ $record?->created_at->format('d-M h:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4" id="rowBody{{$number->id}}">
                            <p class="mb-3 text-muted">
                                <i class="fas fa-map-marker-alt mr-2 text-danger"></i>{{ $number->city }}
                                @if ($number->userNumbers->first())
                                    • <i
                                        class="fas fa-user mr-2 text-primary"></i>{{ $number->userNumbers->first()->user->name }}
                                @endif
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <button class="btn btn-outline-primary btn-sm rounded-pill" type="button"
                                    data-toggle="collapse" data-target="#collapse{{ $number->id }}">
                                    <i class="fas fa-chevron-down mr-1"></i> More details
                                </button>
                                <a href="tel:{{ $number->phone_number }}" class="btn btn-success btn-sm rounded-pill"
                                    onclick="handleCall(event, '{{ $number->phone_number }}', '{{ $number->id }}')">
                                    <i class="fas fa-phone mr-1"></i> Call
                                </a>
                            </div>

                            <div class="collapse mt-4" id="collapse{{ $number->id }}">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Number</span>
                                        <span class="text-primary">{{ $number->phone_number }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">N/S</span>
                                        <span
                                            class="badge badge-{{ $number?->status == 'Interested' ? 'success' : 'secondary' }} badge-pill" id="numberStatus{{$number->id}}">{{ $number?->status }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Response</span>
                                        <span class="badge badge-info badge-pill" id="recordStatus{{$number->id}}">{{ $record?->status }}</span>
                                    </li>
                                    <li class="list-group-item py-2">
                                        <span class="font-weight-bold">Description</span>
                                        <p class="mb-0 mt-2 text-muted" id="description{{$number->id}}">{{ $record?->description }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Callback</span>
                                        <span class="text-danger" id="callBack{{$number->id}}">{{ $record?->have_to_call?->format('d-M h:i') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Count</span>
                                        <span
                                            class="badge badge-primary badge-pill" id="count{{$number->id}}">{{ $number->callRecords->count() }}</span>
                                    </li>
                                    @role('super_admin|admin')
                                        <li class="list-group-item py-2">
                                            <span class="font-weight-bold">Assigned Users</span>
                                            <ul class="list-unstyled mb-0 mt-2">
                                                @foreach ($number->userNumbers as $user)
                                                    <li class="mb-1">
                                                        <i
                                                            class="fas fa-user-check mr-2 text-success"></i>{{ $user->user->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endrole
                                </ul>

                                <div class="mt-3">
                                    <div class="btn-group d-flex" role="group">
                                        <button type="button" class="btn btn-warning btn-sm flex-grow-1 mb-2"
                                            data-toggle="modal" data-target="#responseModal{{ $number->id }}">
                                            <i class="fas fa-reply mr-1"></i> Response
                                        </button>
                                        <a href="{{ route('callRecord.show', ['number' => $number->id]) }}"
                                            class="btn btn-primary btn-sm flex-grow-1 mb-2">
                                            <i class="fas fa-history mr-1"></i> Records
                                        </a>
                                    </div>
                                </div>

                                <form action="{{ route('demo.send', ['number' => $number->id]) }}" id="demoSendForm{{$number->id}}" method="post"
                                    class="mt-3">
                                    @csrf
                                    <select name="demo_id" class="form-control form-control-sm mb-2">
                                        <option value="">Select Demo</option>
                                        @foreach ($demos as $demo)
                                            <option value="{{ $demo->id }}">{{ $demo->name . ' - ' . $demo->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <textarea name="custom_message" class="form-control form-control-sm mb-2" placeholder="Custom Message"
                                        rows="2"></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block rounded-pill">
                                        <i class="fas fa-paper-plane mr-1"></i> Send Demo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="responseModal{{ $number->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="responseModalLabel{{ $number->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="responseModalLabel{{ $number->id }}">
                                        <i class="fas fa-comment-alt mr-2"></i>Response Form
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="callRecordForm{{ $number->id }}" role="form" action="{{ route('callRecord.store', ['number' => $number->id]) }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="status{{ $number->id }}">Response</label>
                                            <select name="status" id="status{{ $number->id }}" class="form-control">
                                                <option value="">Select Response</option>
                                                <option value="call pick">Call Pick</option>
                                                <option value="call not pick">Call Not Pick</option>
                                                <option value="call back">Call Back</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="number_status{{ $number->id }}">Number Status</label>
                                            <select name="number_status" id="number_status{{ $number->id }}" class="form-control">
                                                <option value="">Select Number Status</option>
                                                <option value="interested">Interested</option>
                                                <option value="not interested">Not Interested</option>
                                                <option value="wrong number">Wrong Number</option>
                                                <option value="converted">Converted</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="description{{ $number->id }}">Description</label>
                                            <textarea name="description" id="description{{ $number->id }}" rows="4" class="form-control" placeholder="Enter description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="date_and_time{{ $number->id }}">Call back time</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input name="date_and_time" id="date_and_time{{ $number->id }}" type="datetime-local" class="form-control" placeholder="Select date and time" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="send_message{{ $number->id }}" name="send_message" value="true">
                                                <label class="custom-control-label" for="send_message{{ $number->id }}">Send message to this number</label>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-2"></i>Submit</button>
                                        </div>
                                    </form>

                                    <script>
                                        // $(document).ready(function() {
                                        $('#callRecordForm{{ $number->id }}').on('submit', function(e) {
                                            e.preventDefault();

                                            let form = $(this);
                                            let actionUrl = form.attr('action');
                                            let formData = form.serialize();

                                            $.ajax({
                                                type: 'POST',
                                                url: actionUrl,
                                                data: formData,
                                                success: function(response) {
                                                    $('#responseModal{{ $number->id }}').modal('hide');
                                                    // Handle success - you can show a success message, close the modal, etc.
                                                    $('#numberStatus{{ $number->id }}').text(response.record.number_status);
                                                    $('#recordStatus{{ $number->id }}').text(response.record.status);
                                                    $('#description{{ $number->id }}').text(response.record.description);
                                                    $('#callBack{{ $number->id }}').text(response.callBack);
                                                    $('#lastCall{{ $number->id }}').text(response.created_at);
                                                    $('#count{{ $number->id }}').text({{$number->callRecords->count() + 1}});
                                                    $('#count{{ $number->id }}').text({{$number->callRecords->count() + 1}});
                                                    let statusClass = getStatusClass(response.record.number_status);
                                                    $('#rowBody{{ $number->id }}').css({
                                                        'border-left': '5px solid ' + statusClass
                                                    });
                                                    alert(response.message);
                                                },
                                                error: function(xhr) {
                                                    if (xhr.status === 422) {
                                                        // Validation error
                                                        let errors = xhr.responseJSON.errors;
                                                        let errorMessages = '';
                                                        $.each(errors, function(key, value) {
                                                            errorMessages += value + '\n';
                                                        });
                                                        alert('Validation error:\n' + errorMessages);
                                                    } else {
                                                        // General error
                                                        alert('An error occurred. Please try again.');
                                                    }
                                                }
                                            });
                                        });
                                        // });


                                        $('#demoSendForm{{ $number->id }}').on('submit', function(e) {
                                            e.preventDefault();

                                            let form = $(this);
                                            let actionUrl = form.attr('action');
                                            let formData = form.serialize();

                                            $.ajax({
                                                type: 'POST',
                                                url: actionUrl,
                                                data: formData,
                                                success: function(response) {
                                                    if (response.success) {
                                                        alert(response.success); // Show success message
                                                    } else if (response.error) {
                                                        alert(response.error); // Show error message from response
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    // If the response status is not 200 (success), this block will be executed
                                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                                        alert(xhr.responseJSON.error); // Show error message from response JSON
                                                    } else {
                                                        alert('An unexpected error occurred.'); // Show a general error message
                                                    }
                                                }
                                            });
                                        });

                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach ($allNumbers as $number)
                    @php
                        if ($number->callRecords->count() == 0) {
                            continue;
                        }
                        if($status == null){
                            if ($number->status == 'not interested' || $number->status == 'wrong number' || $number->status == 'converted'){
                                if ($numberSearch == null){
                                continue;
                                }
                            }
                        }
                        $record = $number->callRecords()->latest()->first();
                    @endphp
                    <div class="card mb-4 shadow-lg rounded-lg overflow-hidden border border-light" id="{{$lastCall->id == $number->id ? 'lastCall' : ''}}">
                        <div class="card-header bg-primary text-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 font-weight-bold text-truncate">{{ $number->business_name }}</h5>
                                <span class="badge badge-light badge-pill" id="lastCall{{$number->id}}">
                                    {{ $record?->created_at->format('d-M h:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4" id="rowBody{{$number->id}}" style="border-left: 5px solid {{getStatusClass($number->status)}}">
                            <p class="mb-3 text-muted">
                                <i class="fas fa-map-marker-alt mr-2 text-danger"></i>{{ $number->city }}
                                @if ($number->userNumbers->first())
                                    • <i
                                        class="fas fa-user mr-2 text-primary"></i>{{ $number->userNumbers->first()->user->name }}
                                @endif
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <button class="btn btn-outline-primary btn-sm rounded-pill" type="button"
                                    data-toggle="collapse" data-target="#collapse{{ $number->id }}">
                                    <i class="fas fa-chevron-down mr-1"></i> More details
                                </button>
                                <a href="tel:{{ $number->phone_number }}" class="btn btn-success btn-sm rounded-pill"
                                    onclick="handleCall(event, '{{ $number->phone_number }}', '{{ $number->id }}')">
                                    <i class="fas fa-phone mr-1"></i> Call
                                </a>
                            </div>

                            <div class="collapse mt-4" id="collapse{{ $number->id }}">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Number</span>
                                        <span class="text-primary">{{ $number->phone_number }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">N/S</span>
                                        <span id="numberStatus{{$number->id}}"
                                            class="badge badge-{{ $number?->status == 'Interested' ? 'success' : 'secondary' }} badge-pill">{{ $number?->status }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Response</span>
                                        <span class="badge badge-info badge-pill" id="recordStatus{{$number->id}}">{{ $record?->status }}</span>
                                    </li>
                                    <li class="list-group-item py-2">
                                        <span class="font-weight-bold">Description</span>
                                        <p class="mb-0 mt-2 text-muted" id="description{{$number->id}}">{{ $record?->description }}</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Callback</span>
                                        <span class="text-danger" id="callBack{{$number->id}}">{{ $record?->have_to_call?->format('d-M h:i') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="font-weight-bold">Count</span>
                                        <span
                                            class="badge badge-primary badge-pill" id="count{{$number->id}}">{{ $number->callRecords->count() }}</span>
                                    </li>
                                    @role('super_admin|admin')
                                        <li class="list-group-item py-2">
                                            <span class="font-weight-bold">Assigned Users</span>
                                            <ul class="list-unstyled mb-0 mt-2">
                                                @foreach ($number->userNumbers as $user)
                                                    <li class="mb-1">
                                                        <i
                                                            class="fas fa-user-check mr-2 text-success"></i>{{ $user->user->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endrole
                                </ul>

                                <div class="mt-3">
                                    <div class="btn-group d-flex" role="group">
                                        <button type="button" class="btn btn-warning btn-sm flex-grow-1 mb-2"
                                            data-toggle="modal" data-target="#responseModal{{ $number->id }}">
                                            <i class="fas fa-reply mr-1"></i> Response
                                        </button>
                                        <a href="{{ route('callRecord.show', ['number' => $number->id]) }}"
                                            class="btn btn-primary btn-sm flex-grow-1 mb-2">
                                            <i class="fas fa-history mr-1"></i> Records
                                        </a>
                                    </div>
                                </div>

                                <form action="{{ route('demo.send', ['number' => $number->id]) }}" id="demoSendForm{{$number->id}}" method="post"
                                    class="mt-3">
                                    @csrf
                                    <select name="demo_id" class="form-control form-control-sm mb-2">
                                        <option value="">Select Demo</option>
                                        @foreach ($demos as $demo)
                                            <option value="{{ $demo->id }}">{{ $demo->name . ' - ' . $demo->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <textarea name="custom_message" class="form-control form-control-sm mb-2" placeholder="Custom Message"
                                        rows="2"></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block rounded-pill">
                                        <i class="fas fa-paper-plane mr-1"></i> Send Demo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="responseModal{{ $number->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="responseModalLabel{{ $number->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="responseModalLabel{{ $number->id }}">
                                        <i class="fas fa-comment-alt mr-2"></i>Response Form
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="callRecordForm{{ $number->id }}" role="form" action="{{ route('callRecord.store', ['number' => $number->id]) }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="status{{ $number->id }}">Response</label>
                                            <select name="status" id="status{{ $number->id }}" class="form-control">
                                                <option value="">Select Response</option>
                                                <option value="call pick">Call Pick</option>
                                                <option value="call not pick">Call Not Pick</option>
                                                <option value="call back">Call Back</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="number_status{{ $number->id }}">Number Status</label>
                                            <select name="number_status" id="number_status{{ $number->id }}" class="form-control">
                                                <option value="">Select Number Status</option>
                                                <option value="interested">Interested</option>
                                                <option value="not interested">Not Interested</option>
                                                <option value="wrong number">Wrong Number</option>
                                                <option value="converted">Converted</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="description{{ $number->id }}">Description</label>
                                            <textarea name="description" id="description{{ $number->id }}" rows="4" class="form-control" placeholder="Enter description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="date_and_time{{ $number->id }}">Call back time</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input name="date_and_time" id="date_and_time{{ $number->id }}" type="datetime-local" class="form-control" placeholder="Select date and time" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="send_message{{ $number->id }}" name="send_message" value="true">
                                                <label class="custom-control-label" for="send_message{{ $number->id }}">Send message to this number</label>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-2"></i>Submit</button>
                                        </div>
                                    </form>

                                    <script>
                                        // $(document).ready(function() {
                                        $('#callRecordForm{{ $number->id }}').on('submit', function(e) {
                                            e.preventDefault();

                                            let form = $(this);
                                            let actionUrl = form.attr('action');
                                            let formData = form.serialize();

                                            $.ajax({
                                                type: 'POST',
                                                url: actionUrl,
                                                data: formData,
                                                success: function(response) {
                                                    $('#responseModal{{ $number->id }}').modal('hide');
                                                    // Handle success - you can show a success message, close the modal, etc.
                                                    $('#numberStatus{{ $number->id }}').text(response.record.number_status);
                                                    $('#recordStatus{{ $number->id }}').text(response.record.status);
                                                    $('#description{{ $number->id }}').text(response.record.description);
                                                    $('#callBack{{ $number->id }}').text(response.callBack);
                                                    $('#lastCall{{ $number->id }}').text(response.callBack);
                                                    $('#count{{ $number->id }}').text({{$number->callRecords->count() + 1}});
                                                    let statusClass = getStatusClass(response.record.number_status);
                                                    $('#rowBody{{ $number->id }}').css({
                                                        'border-left': '5px solid ' + statusClass
                                                    });
                                                    alert(response.message);
                                                },
                                                error: function(xhr) {
                                                    if (xhr.status === 422) {
                                                        // Validation error
                                                        let errors = xhr.responseJSON.errors;
                                                        let errorMessages = '';
                                                        $.each(errors, function(key, value) {
                                                            errorMessages += value + '\n';
                                                        });
                                                        alert('Validation error:\n' + errorMessages);
                                                    } else {
                                                        // General error
                                                        alert('An error occurred. Please try again.');
                                                    }
                                                }
                                            });
                                        });
                                        // });

                                        $('#demoSendForm{{ $number->id }}').on('submit', function(e) {
                                            e.preventDefault();

                                            let form = $(this);
                                            let actionUrl = form.attr('action');
                                            let formData = form.serialize();

                                            $.ajax({
                                                type: 'POST',
                                                url: actionUrl,
                                                data: formData,
                                                success: function(response) {
                                                    if (response.success) {
                                                        alert(response.success); // Show success message
                                                    } else if (response.error) {
                                                        alert(response.error); // Show error message from response
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    // If the response status is not 200 (success), this block will be executed
                                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                                        alert(xhr.responseJSON.error); // Show error message from response JSON
                                                    } else {
                                                        alert('An unexpected error occurred.'); // Show a general error message
                                                    }
                                                }
                                            });
                                        });

                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>









    {{--    <script>--}}
{{--        document.querySelector('a[href="#Number{{$lastCall->id}}"]').addEventListener('click', function(e) {--}}
{{--            e.preventDefault();--}}
{{--            document.getElementById('Number{{$lastCall->id}}').scrollIntoView({ behavior: 'smooth' });--}}
{{--        });--}}
{{--    </script>--}}

    <script>
        $(window).on('load', function() {
            $('#preloader').fadeOut('slow', function() {
                $(this).remove();
            });
        });

        function handleCall(event, phoneNumber, numberId) {
            event.preventDefault(); // Prevent the default action

            // Initiate the call
            window.location.href = 'tel:' + phoneNumber;

            // Set a timeout to open the modal after 5 seconds
            setTimeout(function() {
                $('#responseModal' + numberId).modal('show');
            }, 5000);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                const checkboxes = document.querySelectorAll('input[name="numbers[]"]');

                selectAllCheckbox.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });
            }

            // document.querySelectorAll('.qr-code').forEach(function(element) {
            //     var phoneNumber = element.getAttribute('data-phone');
            //     new QRCode(element, {
            //         text: 'tel:' + phoneNumber,
            //         width: 100,
            //         height: 100
            //     });
            // });

            const params = new URLSearchParams(window.location.search);
            const savedNumberId = params.get('saved_number_id');

            console.log('URL Parameters:', params.toString());
            console.log('Saved Number ID:', savedNumberId);

            if (savedNumberId) {
                const row = document.getElementById(`row-${savedNumberId}`);
                console.log('Row Element:', row);

                if (row) {
                    console.log('Viewport Height:', window.innerHeight);
                    console.log('Row Offset Top:', row.offsetTop);
                    row.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    row.classList.add('highlight');

                    setTimeout(() => {
                        row.style.backgroundColor = 'yellow';
                        setTimeout(() => {
                            row.style.backgroundColor = '';
                        }, 2000);
                    }, 500);
                } else {
                    console.log('Row not found');
                }
            }
        });


        function getStatusClass($status) {
            switch ($status) {
                case 'call pick':
                    return '';
                case 'call not pick':
                    return 'bg-warning';
                case 'call back':
                    return 'blue';
                case 'interested':
                    return 'green';
                case 'not interested':
                    return 'red';
                case 'wrong number':
                    return 'black';
                default:
                    return '';
            }
        }
    </script>

    <style>
        /* Preloader Styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner-grow {
            width: 3rem;
            height: 3rem;
        }
        #preloader p {
            color: #007bff;
            font-size: 1.5rem;
        }

        .highlight {
            background-color: yellow;
            animation: highlightAnimation 2s ease-in-out;
        }

        @keyframes highlightAnimation {
            from {
                background-color: yellow;
            }

            to {
                background-color: transparent;
            }
        }
    </style>
@endsection
