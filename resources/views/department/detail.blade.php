{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')

<div class="container">
    <div class="row text-center">
      <div class="col-md-12">
        <p>Tenure: 
            @php
                $tenure_end =  !empty($committee->tenure_end_date) ? "/ " . date('Y', strtotime($committee->tenure_end_date)) : __('/ Present');
            @endphp
          {{ date('Y', strtotime($committee->tenure_start_date)) }} @php echo $tenure_end; @endphp</td></p>
        </div>
      </div>


    @if(!empty($committee->president))
        @php $president = $User->getUser($committee->president); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($president['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $president['id'] .'/'. $president['member_photo'] @endphp" width="150px" />
                @endif
                <p>President: {{ $president['name'] }}</p>
            </div>
        </div>
    @endif


    @if(!empty($committee->first_vc_president))
        @php $first_vc_president = $User->getUser($committee->first_vc_president); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($first_vc_president['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $first_vc_president['id'] .'/'. $first_vc_president['member_photo'] @endphp" width="150px" />
                @endif
                <p>First Vice President: {{ $first_vc_president['name'] }}</p>
            </div>
        </div>
    @endif

    @if(!empty($committee->second_vc_president))
        @php $second_vc_president = $User->getUser($committee->second_vc_president); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($second_vc_president['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $second_vc_president['id'] .'/'. $second_vc_president['member_photo'] @endphp" width="150px" />
                @endif
                <p>Second Vice President: {{ $second_vc_president['name'] }}</p>
            </div>
        </div>
    @endif

    @if(!empty($committee->general_secretary))
        @php $general_secretary = $User->getUser($committee->general_secretary); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($general_secretary['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $general_secretary['id'] .'/'. $general_secretary['member_photo'] @endphp" width="150px" />
                @endif
                <p>General Secretary: {{ $general_secretary['name'] }}</p>
            </div>
        </div>
    @endif

    @if(!empty($committee->secretary))
        @php $secretary = $User->getUser($committee->secretary); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($secretary['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $secretary['id'] .'/'. $secretary['member_photo'] @endphp" width="150px" />
                @endif
                <p>Secretary: {{ $secretary['name'] }}</p>
            </div>
        </div>
    @endif


    @if(!empty($committee->treasurer))
        @php $treasurer = $User->getUser($committee->treasurer); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($treasurer['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $treasurer['id'] .'/'. $treasurer['member_photo'] @endphp" width="150px" />
                @endif
                <p>Treasurer: {{ $treasurer['name'] }}</p>
            </div>
        </div>
    @endif

    @if(!empty($committee->vc_treasurer))
        @php $vc_treasurer = $User->getUser($committee->vc_treasurer); @endphp
        <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($vc_treasurer['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $vc_treasurer['id'] .'/'. $vc_treasurer['member_photo'] @endphp" width="150px" />
                @endif
                <p>Vice treasurer: {{ $vc_treasurer['name'] }}</p>
            </div>
        </div>
    @endif

    @if(!empty($committee->members))
    <p> Members </p>
        @foreach (json_decode($committee->members) as $comember)
            @php $membr = $User->getUser($comember); @endphp
            <div class="row text-center">
            <div class="col-md-12">
                @if (!empty($membr['member_photo']))
                    <img src="@php echo URL::to('/').'/uploads/members/'. $membr['id'] .'/'. $membr['member_photo'] @endphp" width="150px" />
                @endif
                <p> {{ $membr['name'] }}</p>
            </div>
            </div>
        @endforeach
    @endif
</div>
@endsection