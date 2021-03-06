@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12">
        <p><a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('event.list', 'All') }}">{{ __('Go Back') }}</a></p>
      </div>
      <div class="col-md-12">
        <h3>{{ $event->title }}</h3>
      </div>
      <div class="col-md-12">
        <br>
        @php 
        $eventStartDate = date_create($event->start_date);
        $eventStartDate = date_format($eventStartDate,"D, d M Y | h:i A");
        $eventEndDate = date_create($event->end_date);
        $eventEndDate = date_format($eventEndDate,"D, d M Y | h:i A");
        @endphp
        <p><strong>Start: {{ $eventStartDate }}</strong></p>
        <p><strong>End: {{ $eventEndDate }}</strong></p>

      </div>

      <div class="col-md-12">
        <p>{{ $event->description }}</p>

      </div>

      <div class="col-md-12">
        
        @php
        if(!empty($event->photo))
              echo '<img src="'.$event->photo .'" width="150px">';
          else {
            echo '<img src="'. Helper::getPlaceholderImage() . '">';
          }

          @endphp
        </div>
      </div>
</div>
@endsection