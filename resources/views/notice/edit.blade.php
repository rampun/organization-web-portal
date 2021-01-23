@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Edit Notice") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('notice.create') }}">{{ __('Add New') }}</a>
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

          <form method="POST" action="{{ url('notice/update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $notice->id }}" name="id">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="title">
                  Title *
              </label>
                <input type="text" value="{{ $notice->title }}" name="title" class="form-control" id="title">
              </div>
              

              <div class="form-group col-md-12">
                <label for="description">Description *
                </label>
                <textarea rows="6" name="description" class="form-control" id="description">{{ $notice->description }}</textarea>
              </div>
            </div>

            <div class="form-row">
              
            {{-- Status --}}
            <div class="form-group">
              <label for="notice_status">Status</label>
              <select class="form-control" name="notice_status" id="notice_status">
                <option value="Publish" @php echo $notice->status == 'Publish' ? 'selected' : ''; @endphp >Publish</option>
                <option value="Draft"@php echo $notice->status == 'Draft' ? 'selected' : ''; @endphp>Draft</option>
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
