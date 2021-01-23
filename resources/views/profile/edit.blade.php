@extends('layout.app')

@section('content')


<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Edit Profile") }}</h1>
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

          {{-- <form method="POST" action="{{ url('profile/update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

          <input type="hidden" name="userId" value="{{ $userDetail['id'] }}">

            <h5 class="text-gray-800"> Avatar</h5>
            <div class="form-row">
              <div class="form-group col-md-4">
                <div class="pun_flex">
                  <div>
                    @if(!empty($userDetail['member_photo'] )) 
                      <img src="<?php //echo URL::to('/').'/uploads/members/'.$userDetail['id'] .'/'. $userDetail['member_photo'];?>" width="90px">
                    @endif
                  </div>
                  <div>
                    <input type="file" name="member_photo" value="" class="form-control" id="member_photo">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group  col-md-12">
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success">{{ __('Update') }}</button>
              </div>
            </div>
          </form> --}}

{{-- 
          <form method="POST" action="{{ url('profile/update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

          <input type="hidden" name="user_id" value="{{ $userDetail['id'] }}">
          <input type="hidden" name="updateable_field" value="full_name">
            <h5 class="text-gray-800"> Name </h5>

          <div class="form-row">

            <div class="form-group col-md-8">
              <label for="full_name">
                Full Name
                @if ($errors->has('full_name'))
                <span class="text-danger">({{ $errors->first('full_name') }})</span>
              @endif</label>
              <input type="text"  name="full_name" value="{{ $userDetail['name'] }}" class="form-control" id="full_name">
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group  col-md-12">
              <button type="submit" class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success">{{ __('Update') }}</button>
            </div>
          </div>
        </form> --}}


          <form method="POST" action="{{ url('profile/changePassword') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

          <input type="hidden" name="userId" value="{{ $userDetail['id'] }}">
            <h5 class="text-gray-800"> Change Password</h5>

          <div class="form-row">

            <div class="form-group col-md-8">
              <label for="currentPassword">
                Old Password *
                @if ($errors->has('currentPassword'))
                <span class="text-danger">({{ $errors->first('currentPassword') }})</span>
              @endif</label>
              <input type="password"  name="currentPassword" value="{{ old('currentPassword') }}" class="form-control" id="currentPassword">
            </div>

          </div>
          
          <div class="form-row">
            <div class="form-group col-md-4">
                <label for="newPassord1">New Password *
                  @if ($errors->has('newPassord1'))
                  <span class="text-danger">({{ $errors->first('newPassord1') }})</span>
                @endif

                </label>
                <input type="password"  name="newPassord1" value="{{ old('newPassord1') }}" class="form-control" id="newPassord1">
              </div>

              <div class="form-group col-md-4">
                <label for="newPassord2">
                  Confirm Password *
                  @if ($errors->has('newPassord2'))
                  <span class="text-danger">({{ $errors->first('newPassord2') }})</span>
                @endif</label>
                <input type="password"  name="newPassord2" value="{{ old('newPassord2') }}" class="form-control" id="newPassord2">
              </div>
            </div>

            {{-- Update Button--}}
            <div class="form-row">
              <div class="form-group  col-md-12">
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success">{{ __('Update') }}</button>
              </div>
            </div>

          </form>
        </div>
      </div>
</div>

  @endsection
