@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Edit Event") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('event.create') }}">{{ __('Add New') }}</a>
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

          <form method="POST" action="{{ url('event/update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $event->id }}" name="id">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="title">
                  Title *
              </label>
                <input type="text" value="{{ $event->title }}" name="title" class="form-control" id="title">
              </div>
              
              {{-- Start Date --}}
              <div class="form-group col-md-4">
                <label for="start_date">
                  Start Date *
              </label>
                <input type="text"  name="start_date" value="{{ $event->start_date }}" class="form-control custom_event_date_picker" id="start_date">
              </div>

              {{-- End Date --}}
              <div class="form-group col-md-4">
                <label for="end_date">End Date *
                </label>
                <input type="text" name="end_date" value="{{ $event->end_date }}" class="form-control custom_event_date_picker" id="end_date">
              </div>

              <div class="form-group col-md-12">
                <label for="description">Description *
                </label>
                <textarea rows="6" name="description" class="form-control" id="description">{{ $event->description }}</textarea>
              </div>
            </div>
            <div class="form-row">
              
              {{-- Event Photo --}}
              <div class="form-group col-md-4">
                <label for="photo">Photo</label>
                <div class="pun_flex">
                  <div>
                    <img src="<?php echo URL::to('/').$event->photo;?>" width="90px">
                  </div>
                  <div>
                    <input type="file" name="photo" class="form-control" id="photo">
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              
            {{-- Status --}}
            <div class="form-group">
              <label for="event_status">Status</label>
              <select class="form-control" name="event_status" id="event_status">
                <option value="Publish" @php echo $event->status == 'Publish' ? 'selected' : ''; @endphp >Publish</option>
                <option value="Draft"@php echo $event->status == 'Draft' ? 'selected' : ''; @endphp>Draft</option>
              </select>
            </div>
          </div>

            {{-- Update Event Button--}}
            <button type="submit" class="btn btn-sm btn-success">{{ __('Update') }}</button>
          </form>
        </div>
    </div>
</div>

  @endsection
