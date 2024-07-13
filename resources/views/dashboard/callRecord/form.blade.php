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
                                <option value="call pick" {{ old('status') == 'call pick' ? 'selected' : '' }}>Call Pick</option>
                                <option value="call not pick" {{ old('status') == 'call not pick' ? 'selected' : '' }}>Call Not Pick</option>
                                <option value="call back" {{ old('status') == 'call back' ? 'selected' : '' }}>Call Back</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select name="number_status" class="form-control custom-select">
                                <option value="">Number Status</option>
                                <option value="interested" {{ old('number_status') == 'interested' ? 'selected' : '' }}>Interested</option>
                                <option value="not interested" {{ old('number_status') == 'not interested' ? 'selected' : '' }}>Not Interested</option>
                                <option value="wrong number" {{ old('number_status') == 'wrong number' ? 'selected' : '' }}>Wrong Number</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Description" style="resize: none;">{{old('description')}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <input name="date_and_time" type="datetime-local" class="form-control" placeholder="Have to call" value="{{old('date_and_time')}}"/>
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
