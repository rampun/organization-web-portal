{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')
@section('class', 'committee-page')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Committees") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('committee.create') }}">{{ __('Add New') }}</a>
  </div>

    <div class="row">
      <div class="col-md-12">
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
      </div>
    </div>

    {{-- Post Status Component --}}
    <div class="row">
      <div class="col-md-12">
        @component('component.post-status-component')
          {{-- All Post --}}
          @slot('allRoute')
            @php echo route('committee.list', 'All')  @endphp
          @endslot
          @slot('allClass')
            @php echo $status=="All" ? "current" : ""; @endphp
          @endslot 
          @slot('allCount')
            @php echo $committeeCount['All']; @endphp
          @endslot

          {{-- Publish post --}}
          @slot('publishRoute')
            @php echo route('committee.list', 'Publish')  @endphp
          @endslot
          @slot('publishClass')
            @php echo $status=="Publish" ? "current" : ""; @endphp
          @endslot
          @slot('publishCount')
            @php echo $committeeCount['Publish']; @endphp
          @endslot

          {{-- Draft Post --}}
          @slot('draftRoute')
            @php echo route('committee.list', 'Draft')  @endphp
          @endslot
          @slot('draftClass')
            @php echo $status=="Draft" ? "current" : ""; @endphp
          @endslot
          @slot('draftCount')
            @php echo $committeeCount['Draft']; @endphp
          @endslot

          {{-- Trash Post --}}
          @slot('trashRoute')
            @php echo route('committee.list', 'Trash')  @endphp
          @endslot
          @slot('trashClass')
            @php echo $status=="Trash" ? "current" : ""; @endphp
          @endslot
          @slot('trashCount')
            @php echo $committeeCount['Trash']; @endphp
          @endslot
        @endcomponent
      </div>
    </div>

  <div class="row">
      <div class="col-md-12">
        <table class="table list">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tenure</th>
                <th scope="col">President</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

    @php 
      $i = 1; 
    @endphp

    @foreach ($committees as $committee)
    @php
    if(!empty($committee->president))
    {
      $president = $User->getUser($committee->president);
    }
    if(!empty($committee->first_vc_president))
    {
      $first_vc_president = $User->getUser($committee->first_vc_president);
    }
    if(!empty($committee->second_vc_president))
    {
      $second_vc_president = $User->getUser($committee->second_vc_president);
    }
    if(!empty($committee->general_secretary))
    {
      $general_secretary = $User->getUser($committee->general_secretary);
    }
    if(!empty($committee->secretary))
    {
      $secretary = $User->getUser($committee->secretary);
    }
    if(!empty($committee->treasurer))
    {
      $treasurer = $User->getUser($committee->treasurer);
    }
    if(!empty($committee->vc_treasurer))
    {
      $vc_treasurer = $User->getUser($committee->vc_treasurer);
    }
    if(!empty($committee->members))
    {
      // $members = $User->getUser($committee->members);
    }
      
    @endphp

<tr>
<th scope="row">@php echo $i++ @endphp </th>
<td>
  @php 
    $tenure_end =  !empty($committee->tenure_end_date) ? "/ " . date('Y', strtotime($committee->tenure_end_date)) : __('/ Present');
  @endphp
  <a href="{{ route('committee.detail',$committee["id"]) }}">
    {{ date('Y', strtotime($committee->tenure_start_date)) }} @php echo $tenure_end; @endphp
  </a>
  @if ($committee->status == 'Draft'  && $status!='Draft')
    <span class="post-state"> — Draft</span>
  @endif
</td>

<td>
  <a href="{{ route('member.detail',$president['id']) }} "> {{ $president['name'] }} </a>
</td>
  <td>
    @if($status == 'All' || $status == 'Publish' || $status == 'Draft')
      <a href="{{ route('committee.update',$committee["id"]) }}">
        Edit
      </a>&nbsp;|&nbsp;
        <a href="{{ route('committee.delete',$committee["id"]) }}">
        Delete
      </a>
    @elseif ($status == 'Trash')
      <a href="{{ route('committee.restore',$committee["id"]) }}">
        Restore
      </a>&nbsp;|&nbsp;
      <a href="{{ route('committee.permanentlyDelete',$committee["id"]) }}">
      Delete Permanently
    </a>
    @endif
  </td>
</tr>
        
    @endforeach

            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection