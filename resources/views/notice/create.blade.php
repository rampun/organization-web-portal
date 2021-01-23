@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Add New Notice") }}</h1>
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

          <form method="POST" action="{{ url('notice/create') }}" enctype="multipart/form-data">
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
            {{-- Status --}}
            <div class="form-group">
              <label for="notice_status">Status</label>
              <select class="form-control" name="notice_status" id="notice_status">
                <option value="Publish">Publish</option>
                <option value="Draft">Draft</option>
              </select>
            </div>
          </div>

            {{-- Add Notice Button--}}
            <button type="submit" class="btn btn-sm btn-success">{{ __('Save') }}</button>
          </form>
        </div>
    </div>
</div>

  @endsection
