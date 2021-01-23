<?php 
use Carbon\Carbon;
?>
@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Notices") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('notice.create') }}">{{ __('Add New') }}</a>
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
              @php echo route('notice.list', 'All')  @endphp
            @endslot
            @slot('allClass')
              @php echo $status=="All" ? "current" : ""; @endphp
            @endslot 
            @slot('allCount')
              @php echo $noticeCount['All']; @endphp
            @endslot

            {{-- Publish post --}}
            @slot('publishRoute')
              @php echo route('notice.list', 'Publish')  @endphp
            @endslot
            @slot('publishClass')
              @php echo $status=="Publish" ? "current" : ""; @endphp
            @endslot
            @slot('publishCount')
              @php echo $noticeCount['Publish']; @endphp
            @endslot

            {{-- Draft Post --}}
            @slot('draftRoute')
              @php echo route('notice.list', 'Draft')  @endphp
            @endslot
            @slot('draftClass')
              @php echo $status=="Draft" ? "current" : ""; @endphp
            @endslot
            @slot('draftCount')
              @php echo $noticeCount['Draft']; @endphp
            @endslot

            {{-- Trash Post --}}
            @slot('trashRoute')
              @php echo route('notice.list', 'Trash')  @endphp
            @endslot
            @slot('trashClass')
              @php echo $status=="Trash" ? "current" : ""; @endphp
            @endslot
            @slot('trashCount')
              @php echo $noticeCount['Trash']; @endphp
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
                <th scope="col">Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @if (count($notices)>0)
            @php
              $i = 1;
            @endphp
            @foreach($notices as $notice)
            <tr>
            <th scope="row">{{ $i++ }}</th>
              <td>
                <a href="{{ route('notice.detail',$notice->id) }}">{{ $notice->title }}</a>
                @if ($notice->status == 'Draft' && $status!='Draft')
                  <span class="post-state"> — Draft</span>
                @endif
                </td>
              <td>{{ $notice->description }}</td>
              <td>
                @if($status == 'All' || $status == 'Publish' || $status == 'Draft')
                <a href="{{ route('notice.update',$notice->id) }}">
                  Edit
                </a>&nbsp;|&nbsp;
                  <a href="{{ route('notice.delete',$notice->id) }}">
                  Delete
                </a>
              @elseif ($status == 'Trash')
                <a href="{{ route('notice.restore',$notice->id) }}">
                  Restore
                </a>&nbsp;|&nbsp;
                <a href="{{ route('notice.permanentlyDelete',$notice->id) }}">
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