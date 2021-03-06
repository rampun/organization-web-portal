@extends('layout.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <p><a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('activity.list', 'All') }}">{{ __('Go Back') }}</a></p>
    </div>
    <div class="col-md-12">
      <h3>{{ $activity->title }}</h3>
    </div>
    <div class="col-md-12">
      <br>
      @php 
      $activityStartDate = date_create($activity->start_date);
      $activityStartDate = date_format($activityStartDate,"D, d M Y | h:i A");
      $activityEndDate = date_create($activity->end_date);
      $activityEndDate = date_format($activityEndDate,"D, d M Y | h:i A");
      @endphp
      <p><strong>Start: {{ $activityStartDate }}</strong></p>
      <p><strong>End: {{ $activityEndDate }}</strong></p>

    </div>

    <div class="col-md-12">
      <p>{{ $activity->description }}</p>

    </div>

    <div class="col-md-12">
      
      @php
      if(!empty($activity->photo))
            echo '<img src="'.$activity->photo .'" width="150px">';
        else {
          echo '<img src="' . Helper::getPlaceholderImage() . '">';
        }

        @endphp
      </div>
    </div>
</div>
@endsection