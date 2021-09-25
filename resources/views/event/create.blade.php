@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Add New Event") }}</h1>
  </div>

  <div class="row">
        <div class="col-sm-12">
            {{-- display if success --}}
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
            @endif

            {{-- display if any error --}}
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    @php
                    Session::forget('error');
                @endphp
                </div>
            @endif

          <form method="POST" action="{{ url('event/create') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="title">
                  Title *
                  @if ($errors->has('title'))
                  <span class="text-danger">({{ $errors->first('title') }})</span>
                @endif
              </label>
                <input type="text" value="{{ old('title') }}" name="title" class="form-control" id="title">
              </div>
              
              {{-- Start Date --}}
              <div class="form-group col-md-4">
                <label for="start_date">
                  Start Date *
                  @if ($errors->has('start_date'))
                  <span class="text-danger">({{ $errors->first('start_date') }})</span>
                @endif
              </label>
                <input type="text"  name="start_date" value="{{ old('start_date') }}" class="form-control custom_event_date_picker" id="start_date">
              </div>

              {{-- End Date --}}
              <div class="form-group col-md-4">
                <label for="end_date">End Date *

                  @if ($errors->has('end_date'))
                  <span class="text-danger">({{ $errors->first('end_date') }})</span>
                @endif
                </label>
                <input type="text" name="end_date" value="{{ old('end_date') }}" class="form-control custom_event_date_picker" id="end_date">
              </div>

              <div class="form-group col-md-12">
                <label for="location">
                  Location *
                  @if ($errors->has('location'))
                  <span class="text-danger">({{ $errors->first('location') }})</span>
                @endif
              </label>
                <input type="text" value="{{ old('location') }}" name="location" class="form-control" id="location">
              </div>
              
              <div class="form-group col-md-12">
                <label for="description">Description *
                  @if ($errors->has('description'))
                  <span class="text-danger">({{ $errors->first('description') }})</span>
                @endif

                </label>
                <textarea rows="6" name="description" value="{{ old('description') }}" class="form-control" id="description"></textarea>
              </div>
            </div>
            <div class="form-row">
              
              {{-- Event Photo --}}
              <div class="form-group col-md-4">
                <label for="photo">Photo</label>
                <input type="file" name="photo" value="{{ old('photo') }}" class="form-control" id="photo">
              </div>
            </div>

            <div class="form-row">
              
            {{-- Status --}}
            <div class="form-group">
              <label for="event_status">Status</label>
              <select class="form-control" name="event_status" id="event_status">
                <option value="Publish">Publish</option>
                <option value="Draft">Draft</option>
              </select>
            </div>
          </div>

            {{-- Add Event Button--}}
            <button type="submit" class="btn btn-sm btn-success">{{ __('Save') }}</button>
          </form>
        </div>
    </div>
</div>

  @endsection
