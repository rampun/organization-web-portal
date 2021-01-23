@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Add New Department") }}</h1>
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

          <form method="POST" action="{{ url('department/create') }}" id="departmentForm" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="hidden" id="department_meta" name="department_meta" value='' />
            <div class="form-row">
               {{-- Department Name --}}
              <div class="form-group col-md-4">
                <label for="name">
                  Name *
                  @if ($errors->has('name'))
                  <span class="text-danger">({{ $errors->first('name') }})</span>
                @endif
              </label>
                <input type="text"  name="name" value="{{ old('name') }}" class="form-control" id="name">
              </div>

              {{-- Coordinator --}}
              <div class="form-group col-md-4">
                <label for="coordinator">
                  Coordinator *
                  @if ($errors->has('coordinator'))
                  <span class="text-danger">({{ $errors->first('coordinator') }})</span>
                @endif</label>

                <select id="coordinator" name="coordinator" class="form-control listMembers" >
                 
                </select>
              </div>
         </div>

         <div class="form-row">
          {{-- Has Sub Department --}}
          <div class="form-group col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="hasSubdepartment">
              <label class="form-check-label" for="hasSubdepartment">
                Has Sub Department?
              </label>
            </div>
          </div>
         </div>

          <div id="subDepartmentSection">
            
          </div>

          <div class="form-row">
            <div class="form-group  col-md-12">
              <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" id="addSubdepartment"> Add one row </a>
            </div>
          </div>


             {{-- <div class="form-row">  
            <div class="form-group  col-md-4">
              <label for="status">Status</label>
              <select class="form-control" name="status" id="status">
                <option value="Publish">Publish</option>
                <option value="Draft">Draft</option>
              </select>
            </div>
          </div> --}}

            {{-- Add Event Button--}}
            <div class="form-row">
                <div class="form-group  col-md-12">
                  <button type="submit" id="saveDepartment" class="btn btn-sm btn-success">{{ __('Save') }}</button>
                </div>
              </div>

          </form>
        </div>
    </div>
</div>

  @endsection
