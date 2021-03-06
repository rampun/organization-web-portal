{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')
@section('class', 'committee-page')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p><a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('committee.list', 'All') }}">{{ __('Go Back') }}</a></p>
          </div>
    </div>
    <div class="row text-center">
      <div class="col-md-12">
        <h3>Tenure: 
            @php
                $tenure_end =  !empty($committee->tenure_end_date) ? "/ " . date('Y', strtotime($committee->tenure_end_date)) : __('/ Present');
            @endphp
          {{ date('Y', strtotime($committee->tenure_start_date)) }} @php echo $tenure_end; @endphp</td>
        </h3>
        </div>
      </div>    

      <br>

    @if(!empty($committee->president))
        @php $president = $User->getUser($committee->president); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($president['member_photo']))
                    <img src="@php echo $president['member_photo'] @endphp" />
                @endif
                <p><b>{{ $president['name'] }}</b><br><i>(President)</i></p>
            </div>
        </div>
    @endif

    <br>
        <div class="row text-center">
            <div class="col-md-3">
                
            </div>
            <div class="col-md-3">
                @if(!empty($committee->first_vc_president))
                @php $first_vc_president = $User->getUser($committee->first_vc_president); @endphp
                @if (!empty($first_vc_president['member_photo']))
                    <img src="@php echo $first_vc_president['member_photo'] @endphp" />
                @endif
                <p><b>{{ $first_vc_president['name'] }}</b><br><i>(First Vice President)</i></p>
                @endif
            </div>
            <div class="col-md-3">
                @if(!empty($committee->second_vc_president))
                    @php $second_vc_president = $User->getUser($committee->second_vc_president); @endphp
                            @if (!empty($second_vc_president['member_photo']))
                                <img src="@php echo $second_vc_president['member_photo'] @endphp" />
                            @endif
                            <p><b>{{ $second_vc_president['name'] }}</b><br> <i>(Second Vice President)</i></p>
                    @else
                                <img src="<?php echo Helper::getPlaceholderImage();?>" />
                            <p><b></b><br><i>(Second Vice President)</i></p>
                @endif
            </div>
            <div class="col-md-3">
                
            </div>
        </div>
        <br>
        <div class="row text-center">
            <div class="col-md-3">
                @if(!empty($committee->general_secretary))
                    @php $general_secretary = $User->getUser($committee->general_secretary); @endphp
                    @if (!empty($general_secretary['member_photo']))
                        <img src="@php echo $general_secretary['member_photo'] @endphp" />
                    @endif
                    <p><b>{{ $general_secretary['name'] }}</b><br><i>(General Secretary)</i></p>
                @endif
            </div>
            <div class="col-md-3">
                @if(!empty($committee->secretary))
                    @php $secretary = $User->getUser($committee->secretary); @endphp
                    @if (!empty($secretary['member_photo']))
                        <img src="@php echo $secretary['member_photo'] @endphp" />
                    @endif
                    <p>{{ $secretary['name'] }}<br><i>(Secretary)</i></p>
                    @else
                            <img src="<?php echo Helper::getPlaceholderImage();?>" />
                            <p><b></b><br><i>(Secretary)</i></p>
                @endif
            </div>
            <div class="col-md-3">
                @if(!empty($committee->treasurer))
                    @php $treasurer = $User->getUser($committee->treasurer); @endphp
                    @if (!empty($treasurer['member_photo']))
                        <img src="@php echo $treasurer['member_photo'] @endphp" />
                    @endif
                <p><b>{{ $treasurer['name'] }}</b><br><i>(Treasurer)</i></p>
                @else
                        <img src="<?php echo Helper::getPlaceholderImage();?>" />
                            <p><b></b><br><i>(Treasurer)</i></p>
                @endif
            </div>
            <div class="col-md-3">
                @if(!empty($committee->vc_treasurer))
                    @php $vc_treasurer = $User->getUser($committee->vc_treasurer); @endphp
                    @if (!empty($vc_treasurer['member_photo']))
                        <img src="@php echo $vc_treasurer['member_photo'] @endphp" />
                    @endif
                    <p><b>{{ $vc_treasurer['name'] }}</b><br><i>(Vice treasurer)</i></p>
                    @else
                        <img src="<?php echo Helper::getPlaceholderImage();?>" />
                            <p><b></b><br><i>(Vice Treasurer)</i></p>
                @endif
            </div>
        </div>
        <br><br>
    @if(!empty($committee->members))
    <div class="row text-center">
        <div class="col-md-12">
            <h4> Members </h4>
          </div>
    </div>
    <br>
    <div class="row text-center">
        @foreach (json_decode($committee->members) as $comember)
            @php $membr = $User->getUser($comember); @endphp
            <div class="col-md-3">
                @if (!empty($membr['member_photo']))
                    <img src="@php echo $membr['member_photo'] @endphp" />
                @endif
                <p><b>{{ $membr['name'] }}</b></p>
            </div>
        @endforeach
        </div>
    @endif
</div>
@endsection