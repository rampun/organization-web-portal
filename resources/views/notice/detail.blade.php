@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12">
        <p><a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('notice.list', 'All') }}">{{ __('Go Back') }}</a></p>
      </div>
      <div class="col-md-12">
        <h3>{{ $notice->title }}</h3>
      </div>
      
      <div class="col-md-12">
        <p>{{ $notice->description }}</p>

      </div>

      <div class="col-md-12">
        
        </div>
      </div>
</div>
@endsection