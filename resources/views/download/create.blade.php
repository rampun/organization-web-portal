@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Add New File") }}</h1>
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

      <form method="POST" action="{{ url('download/create') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-row">
          {{-- Start Date --}}
          <div class="form-group col-md-4">
            <label for="file_name">
              File Name *
              @if ($errors->has('file_name'))
              <span class="text-danger">({{ $errors->first('file_name') }})</span>
              @endif
            </label>
            <input type="text" name="file_name" value="{{ old('file_name') }}" class="form-control" id="file_name">
          </div>
        </div>

        <div class="form-row">

          {{-- Download file --}}
          <div class="form-group col-md-4">
            <label for="file">File Upload *</label>
            @if ($errors->has('file'))
            <span class="text-danger">({{ $errors->first('file') }})</span>
            @endif
            <input type="file" name="file" value="{{ old('file') }}" class="form-control" id="file">
          </div>
        </div>

        <div class="form-row">

          {{-- Visibility --}}
          <div class="form-group col-md-4">
            <label for="visibility">Status</label>
            <select class="form-control" name="visibility" id="visibility">
              <option value="Member">Member</option>
              <option value="Public">Public</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          {{-- Status --}}
          <div class="form-group col-md-4">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
              <option value="Publish">Publish</option>
              <option value="Draft">Draft</option>
            </select>
          </div>
        </div>

        {{-- Add Download Button--}}
        <div class="form-row">
          <div class="form-group  col-md-12">
            <button type="submit" class="btn btn-sm btn-success">{{ __('Save') }}</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection