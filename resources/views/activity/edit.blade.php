@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Edit Activity") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('activity.create') }}">{{ __('Add New') }}</a>
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

          <form method="POST" action="{{ url('activity/update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $activity->id }}" name="id">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="title">
                  Title *
              </label>
                <input type="text" value="{{ $activity->title }}" name="title" class="form-control" id="title">
              </div>
              
              {{-- Start Date --}}
              <div class="form-group col-md-4">
                <label for="start_date">
                  Start Date *
              </label>
                <input type="text"  name="start_date" value="{{ $activity->start_date }}" class="form-control custom_event_date_picker" id="start_date">
              </div>

              {{-- End Date --}}
              <div class="form-group col-md-4">
                <label for="end_date">End Date *
                </label>
                <input type="text" name="end_date" value="{{ $activity->end_date }}" class="form-control custom_event_date_picker" id="end_date">
              </div>

              <div class="form-group col-md-12">
                <label for="description">Description *
                </label>
                <textarea rows="6" name="description" class="form-control" id="description">{{ $activity->description }}</textarea>
              </div>
            </div>
            <div class="form-row">
              
              {{-- Event Photo --}}
              <div class="form-group col-md-4">
                <label for="photo">Photo</label>
                <div class="pun_flex">
                  <div>
                    <img src="<?php echo URL::to('/').$activity->photo;?>" width="90px">
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
              <label for="activity_status">Status</label>
              <select class="form-control" name="activity_status" id="activity_status">
                <option value="Publish" @php echo $activity->status == 'Publish' ? 'selected' : ''; @endphp >Publish</option>
                <option value="Draft"@php echo $activity->status == 'Draft' ? 'selected' : ''; @endphp>Draft</option>
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
