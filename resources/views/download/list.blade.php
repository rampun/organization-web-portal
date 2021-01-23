@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Downloads") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('download.create') }}">{{ __('Add New') }}</a>
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
              @php echo route('download.list', 'All')  @endphp
            @endslot
            @slot('allClass')
              @php echo $status=="All" ? "current" : ""; @endphp
            @endslot 
            @slot('allCount')
              @php echo $downloadCount['All']; @endphp
            @endslot

            {{-- Publish post --}}
            @slot('publishRoute')
              @php echo route('download.list', 'Publish')  @endphp
            @endslot
            @slot('publishClass')
              @php echo $status=="Publish" ? "current" : ""; @endphp
            @endslot
            @slot('publishCount')
              @php echo $downloadCount['Publish']; @endphp
            @endslot

            {{-- Draft Post --}}
            @slot('draftRoute')
              @php echo route('download.list', 'Draft')  @endphp
            @endslot
            @slot('draftClass')
              @php echo $status=="Draft" ? "current" : ""; @endphp
            @endslot
            @slot('draftCount')
              @php echo $downloadCount['Draft']; @endphp
            @endslot

            {{-- Trash Post --}}
            @slot('trashRoute')
              @php echo route('download.list', 'Trash')  @endphp
            @endslot
            @slot('trashClass')
              @php echo $status=="Trash" ? "current" : ""; @endphp
            @endslot
            @slot('trashCount')
              @php echo $downloadCount['Trash']; @endphp
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
                <th scope="col">Visibility</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @if (count($downloads)>0)
            @php
              $i = 1;
            @endphp
            @foreach($downloads as $download)
            <tr>
            <th scope="row">{{ $i++ }}</th>
              <td>
                <a href="{{ route('download.detail',$download->id) }}">{{ $download->name }}</a>
                @if ($download->status == 'Draft' && $status!='Draft')
                  <span class="post-state"> — Draft</span>
                @endif
              </td>
              <td>{{ $download->visibility }}</td>
              <td>
                @if($status == 'All' || $status == 'Publish' || $status == 'Draft')
                  <a href="{{ route('download.update',$download->id) }}">
                    Edit
                  </a>&nbsp;|&nbsp;
                    <a href="{{ route('download.delete',$download->id) }}">
                    Delete
                  </a>
                @elseif ($status == 'Trash')
                  <a href="{{ route('download.restore',$download->id) }}">
                    Restore
                  </a>&nbsp;|&nbsp;
                  <a href="{{ route('download.permanentlyDelete',$download->id) }}">
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