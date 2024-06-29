@extends('dash_layouts.aap', ['title' => 'Create Call Record'])
@section('content')
    <div class="row justify-content-center" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="{{ route('callRecord.store', ['number' => $number->id]) }}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group mb-3">
                            <select name="status_id" class="form-control custom-select">
                                <option value="">Response</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="description" id="description" cols="30" rows="1" class="form-control" placeholder="Description" style="resize: none;"></textarea>
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
