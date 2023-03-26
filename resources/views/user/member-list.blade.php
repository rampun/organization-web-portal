@extends('layout.app')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Members") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('member.create') }}">{{ __('Add New') }}</a>
  </div>

  {{-- <div class="height40"></div> --}}
  <div class="row">
    <div class="col-md-2">
      <div class="form-row align-items-center">
        <div class="w-100">
          <select class="custom-select mr-sm-2" id="filter_by_family_name">
            <option value="">Family Name</option>
            @foreach ($familyNames as $fn)
            <option value="{{ $fn }}"> {{ $fn }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-row align-items-center">
        <div class="w-100">
          <select class="custom-select mr-sm-2" id="filter_by_district_hk">
            <option value="">District (HK)</option>
            @foreach ($districtHk as $dhk)
            <option value="{{ $dhk }}"> {{ $dhk }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-row align-items-center">
        <div class="w-100">
          <select class="custom-select mr-sm-2" id="filter_by_district_np">
            <option value="">District (NP)</option>
            @foreach ($districtNp as $dnp)
            <option value="{{ $dnp }}"> {{ $dnp }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-row align-items-center">
        <div class="w-100">
          <select class="custom-select mr-sm-2" id="filter_by_job">
            <option value="">Job</option>
            @foreach ($jobs as $job)
            <option value="{{ $job }}"> {{ $job }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-row justify-content-end">
        <div class="col-md-8">
          <input type="text" class="form-control" id="search_member__input" placeholder="Type to search ...">
        </div>
        <div class="col-auto">
          <a href="/members" class="btn btn-outline-primary mb-2">Reset</a>
        </div>
      </div>
    </div>

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
    <div class="col-md-12">
      <p id="search_count" class="success-color">
        {{-- 4 results Found --}}
      </p>
    </div>
    <div class="col-md-12">
      <div class="pms_loading"></div>
      <table class="table " id="members_listing_table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            {{-- <th scope="col">Family Name</th>
                <th scope="col">District(HK)</th>
                <th scope="col">District(NP)</th> --}}
            {{-- <th scope="col">Job</th> --}}
            <th scope="col">Mobile</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="dynamic_members">
          @if(count($members_detail)>0)
          @php
          $i = 1;
          @endphp
          @foreach($members_detail as $user)
          <tr>
            <th scope="row">{{ $i++ }}</th>
            <td>
              <!-- <a href="{{ route('member.detail',$user['id']) }}"> -->
              {{ $user['name'] }}
              <!-- </a>/ -->
            </td>
            <td>{{ $user['email'] }}</td>
            {{-- <td>{{ $user['family_name'] }}</td>
            <td>{{ $user['district_hk'] }}</td>
            <td>{{ $user['district_np'] }}</td> --}}
            {{-- <td>{{ $user['job'] }}</td> --}}
            <td>{{ $user['mobile_no'] }}</td>
            <td>
              {{-- @if($status == 'All' || $status == 'Publish' || $status == 'Draft') --}}
              <a href="{{ route('member.update',$user['id']) }}">
                Edit
              </a>&nbsp;|&nbsp;
              <a href="{{ route('member.delete',$user['id']) }}">
                Delete
              </a>
              {{-- @elseif ($status == 'Trash')
                    <a href="{{ route('member.restore',$user['id']) }}">
              Restore
              </a>&nbsp;|&nbsp;
              <a href="{{ route('member.permanentlyDelete',$user['id']) }}">
                Delete Permanently
              </a>
              @endif --}}
            </td>
          </tr>
          @endforeach
          @else
          <td colspan="4">No Data</td>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection