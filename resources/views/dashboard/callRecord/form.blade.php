@extends('dash_layouts.aap', ['title' => 'Create Call Record'])
@section('content')
    <div class="row justify-content-center" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="{{ route('callRecord.store', ['number' => $number->id]) }}" method="post" enctype="multipart/form-data" >
                        @csrf

                        <div class="form-group mb-3">
                            <select name="status" class="form-control custom-select">
                                <option value="">Response</option>
                                <option value="call pick">Call Pick</option>
                                <option value="call not pick">Call Not Pick</option>
                                <option value="call back">Call Back</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <select name="number_status" class="form-control custom-select">
                                <option value="">Number Status</option>
                                <option value="interested">Interested</option>
                                <option value="not interested">Not Interested</option>
                                <option value="wrong number">Wrong Number</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Description" style="resize: none;"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <input name="have_to_call" type="datetime-local" class="form-control" placeholder="Have to call" />
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
