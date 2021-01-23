{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __("Edit Committee") }}</h1>
      &nbsp;&nbsp;&nbsp;
      <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('committee.create') }}">{{ __('Add New') }}</a>
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

          <form method="POST" action="{{ url('committee/update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $committee->id }}" name="id">
            <div class="form-row">
               {{-- Start Date --}}
              <div class="form-group col-md-4">
                <label for="start_date">
                  Tenure Start *
                  @if ($errors->has('start_date'))
                  <span class="text-danger">({{ $errors->first('start_date') }})</span>
                @endif
              </label>
                <input type="text"  name="tenure_start_date" value="{{ $committee->tenure_start_date }}" class="form-control custom_date_picker" id="tenure_start_date">
              </div>

              {{-- End Date --}}
              <div class="form-group col-md-4">
                <label for="end_date">Tenure End (<small> Leave empty for present tenure </small>)

                  @if ($errors->has('end_date'))
                  <span class="text-danger">({{ $errors->first('end_date') }})</span>
                @endif
                </label>
                <input type="text" name="tenure_end_date" value="{{ $committee->tenure_end_date }}" class="form-control custom_date_picker" id="tenure_end_date">
              </div>
            </div>

            <div class="form-row">
                {{-- President --}}
              <div class="form-group col-md-4">
                <label for="president">
                  President *
                  @if ($errors->has('president'))
                  <span class="text-danger">({{ $errors->first('president') }})</span>
                @endif</label>

                <select id="president" name="president" class="form-control listMembers" >
                    @if(!empty($committee->president))
                        @php $president = $User->getUser($committee->president); @endphp
                        <option value="{{ $president['id'] }}" selected>
                            {{ $president['name'] }}
                        </option>
                    @endif
                </select>
              </div>

                {{-- First Vice President --}}
                <div class="form-group col-md-4">
                    <label for="first_vc_president">
                      First Vice President *
                      @if ($errors->has('first_vc_president'))
                      <span class="text-danger">({{ $errors->first('first_vc_president') }})</span>
                    @endif</label>
    
                    <select id="first_vc_president" name="first_vc_president" class="form-control listMembers" >
                        @if(!empty($committee->first_vc_president))
                            @php $first_vc_president = $User->getUser($committee->first_vc_president); @endphp
                            <option value="{{ $first_vc_president['id'] }}" selected>
                                {{ $first_vc_president['name'] }}
                            </option>
                        @endif
                    </select>
                  </div>

                    {{-- Second Vice President  --}}
              <div class="form-group col-md-4">
                <label for="second_vc_president">
                  Second Vice President
                  @if ($errors->has('second_vc_president'))
                  <span class="text-danger">({{ $errors->first('second_vc_president') }})</span>
                @endif</label>

                <select id="second_vc_president" name="second_vc_president" class="form-control listMembers" >
                    @if(!empty($committee->second_vc_president))
                        @php $second_vc_president = $User->getUser($committee->second_vc_president); @endphp
                        <option value="{{ $second_vc_president['id'] }}" selected>
                            {{ $second_vc_president['name'] }}
                        </option>
                    @endif
                </select>
              </div>
             </div>


             <div class="form-row">
                {{-- General Secretary --}}
              <div class="form-group col-md-3">
                <label for="generalSecretary">
                  General Secretary *
                  @if ($errors->has('generalSecretary'))
                  <span class="text-danger">({{ $errors->first('generalSecretary') }})</span>
                @endif</label>

                <select id="generalSecretary" name="general_secretary" class="form-control listMembers" >
                    @if(!empty($committee->general_secretary))
                        @php $general_secretary = $User->getUser($committee->general_secretary); @endphp
                        <option value="{{ $general_secretary['id'] }}" selected>
                            {{ $general_secretary['name'] }}
                        </option>
                    @endif
                </select>
              </div>

                {{-- Secretary --}}
                <div class="form-group col-md-3">
                    <label for="secretary">
                      Secretary
                      @if ($errors->has('secretary'))
                      <span class="text-danger">({{ $errors->first('secretary') }})</span>
                    @endif</label>
                    <select id="secretary" name="secretary" class="form-control listMembers" >
                        @if(!empty($committee->secretary))
                            @php $secretary = $User->getUser($committee->secretary); @endphp
                            <option value="{{ $secretary['id'] }}" selected>
                                {{ $secretary['name'] }}
                            </option>
                        @endif
                    </select>
                  </div>

                  {{-- Treasurer --}}
              <div class="form-group col-md-3">
                <label for="treasurer">
                  Treasurer *
                  @if ($errors->has('treasurer'))
                  <span class="text-danger">({{ $errors->first('treasurer') }})</span>
                @endif</label>

                <select id="treasurer" name="treasurer" class="form-control listMembers" >
                    @if(!empty($committee->treasurer))
                        @php $treasurer = $User->getUser($committee->treasurer); @endphp
                        <option value="{{ $treasurer['id'] }}" selected>
                            {{ $treasurer['name'] }}
                        </option>
                    @endif
                </select>
              </div>

                {{-- Vice Treasurer --}}
                <div class="form-group col-md-3">
                    <label for="vc_treasurer">
                      Vice Treasurer
                      @if ($errors->has('vc_treasurer'))
                      <span class="text-danger">({{ $errors->first('vc_treasurer') }})</span>
                    @endif</label>
                    <select id="vc_treasurer" name="vc_treasurer" class="form-control listMembers" >
                        @if(!empty($committee->vc_treasurer))
                            @php $vc_treasurer = $User->getUser($committee->vc_treasurer); @endphp
                            <option value="{{ $vc_treasurer['id'] }}" selected>
                                {{ $vc_treasurer['name'] }}
                            </option>
                        @endif
                    </select>
                  </div>
             </div>

             <div class="form-row">  
             {{-- Members --}}
             <div class="form-group col-md-12">
                <label for="members">
                  Members
                  @if ($errors->has('members'))
                  <span class="text-danger">({{ $errors->first('members') }})</span>
                @endif</label>
                <select id="members" name="members[]" class="form-control listMembers" multiple="multiple">
                    @if(!empty($committee->members))
                        @foreach (json_decode($committee->members) as $member)
                            @php $mem = $User->getUser($member); @endphp
                            <option value="{{ $mem['id'] }}" selected>
                                {{ $mem['name'] }}
                            </option>
                        @endforeach
                    @endif
                </select>
              </div>
         </div>

            
             <div class="form-row">  
            {{-- Status --}}
            <div class="form-group  col-md-12">
              <label for="committee_status">Status</label>
              <select class="form-control" name="committee_status" id="committee_status">
                <option value="Publish" @php echo $committee->status == 'Publish' ? 'selected' : ''; @endphp >Publish</option>
                <option value="Draft"@php echo $committee->status == 'Draft' ? 'selected' : ''; @endphp>Draft</option>
              </select>
            </div>
          </div>

            {{-- Add Event Button--}}
            <div class="form-row">
                <div class="form-group  col-md-12">
                  <button type="submit" class="btn btn-sm btn-success">{{ __('Update') }}</button>
                </div>
              </div>

          </form>
        </div>
    </div>
</div>

  @endsection
