<?php 
use Carbon\Carbon;
?>
@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Activities") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('activity.create') }}">{{ __('Add New') }}</a>
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
            @php echo route('activity.list', 'All')  @endphp
          @endslot
          @slot('allClass')
            @php echo $status=="All" ? "current" : ""; @endphp
          @endslot 
          @slot('allCount')
            @php echo $activityCount['All']; @endphp
          @endslot

          {{-- Publish post --}}
          @slot('publishRoute')
            @php echo route('activity.list', 'Publish')  @endphp
          @endslot
          @slot('publishClass')
            @php echo $status=="Publish" ? "current" : ""; @endphp
          @endslot
          @slot('publishCount')
            @php echo $activityCount['Publish']; @endphp
          @endslot

          {{-- Draft Post --}}
          @slot('draftRoute')
            @php echo route('activity.list', 'Draft')  @endphp
          @endslot
          @slot('draftClass')
            @php echo $status=="Draft" ? "current" : ""; @endphp
          @endslot
          @slot('draftCount')
            @php echo $activityCount['Draft']; @endphp
          @endslot

          {{-- Trash Post --}}
          @slot('trashRoute')
            @php echo route('activity.list', 'Trash')  @endphp
          @endslot
          @slot('trashClass')
            @php echo $status=="Trash" ? "current" : ""; @endphp
          @endslot
          @slot('trashCount')
            @php echo $activityCount['Trash']; @endphp
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
                <th scope="col">Title</th>
                <th scope="col">Start</th>
                <th scope="col">End</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @if (count($activityList)>0)
            @php
              $i = 1;
            @endphp
            @foreach($activityList as $activity)
            <tr>
            <th scope="row">{{ $i++ }}</th>
              <td>
                <a href="{{ route('activity.detail',$activity->id) }}">
                  {{ $activity->title }}
                </a>
                @if ($activity->status == 'Draft' && $status!='Draft')
                  <span class="post-state"> — Draft</span>
                @endif
              </td>
              <td>{{ Carbon::parse($activity->start_date)->format('Y-m-d H:i') }}</td>
              <td>{{ Carbon::parse($activity->end_date)->format('Y-m-d H:i') }}</td>
              <td>
                @if($status == 'All' || $status == 'Publish' || $status == 'Draft')
                <a href="{{ route('activity.update',$activity->id) }}">
                  Edit
                </a>&nbsp;|&nbsp;
                  <a href="{{ route('activity.delete',$activity->id) }}">
                  Delete
                </a>
              @elseif ($status == 'Trash')
                <a href="{{ route('activity.restore',$activity->id) }}">
                  Restore
                </a>&nbsp;|&nbsp;
                <a href="{{ route('activity.permanentlyDelete',$activity->id) }}">
                Delete Permanently
              </a>
              @endif
              </td>
            </tr>
            @endforeach
            @else
              <td colspan="5">No Data</td>
            @endif
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection