{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')


<div class="container-fluid">

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("View Download") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" {{ route('download.list', 'All') }}>{{ __('All Downloads') }}</a>
  </div>

    <div class="row">
        <div class="col-md-12">
            <p>
                File Name: <?php echo !empty($download->name) ? $download->name : ""; ?>
            </p>
        </div>
        <div class="col-md-12">
            <p>
                Visibility: <?php echo !empty($download->visibility) ? $download->visibility : "";?>
            </p>
        </div>
        <div class="col-md-12">
            <p>
                Status: <?php echo !empty($download->status) ? $download->status : "";?>
            </p>
        </div>

        <div class="col-md-12">
            <p>
                <?php if(!empty($download->visibility)) { ?>
                <a href="{{ $download->file }}" target="_blank">{{ __("View File") }}</a> 
                &nbsp;&nbsp;&nbsp;
                <a href="{{ $download->file }}" download>{{ __("Download File") }}</a>
                <?php } ?>
            </p>
        </div>
    </div>
</div>
@endsection