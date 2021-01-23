{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')


<div class="container-fluid">

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("View Download") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('download.list') }}">{{ __('All Downloads') }}</a>
  </div>

    <div class="row">
        <div class="col-md-12">
            <p>
                File Name: {{ $download->name }}
            </p>
        </div>
        <div class="col-md-12">
            <p>
                Visibility: {{ $download->visibility }}
            </p>
        </div>
        <div class="col-md-12">
            <p>
                Status: {{ $download->status }}
            </p>
        </div>

        <div class="col-md-12">
            <p>
                <a href="{{ URL::to('/').$download->file }}" target="_blank">{{ __("View File") }}</a> 
                &nbsp;&nbsp;&nbsp;
                <a href="{{ URL::to('/').$download->file }}" download>{{ __("Download File") }}</a>
            </p>
        </div>
    </div>
</div>
@endsection