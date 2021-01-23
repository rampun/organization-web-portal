@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Suggestions") }}</h1>
  </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table ">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @if (count($suggestions)>0)
            @php
              $i = 1;
            @endphp
            @foreach($suggestions as $suggestion)
            <tr>
              <td scope="row">{{ $i++ }}</td>
              <td>{{ $suggestion->description }}</td>
              <td>
                @if($suggestion->status!='Read')
                  <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('suggestion.markReadUnread', [$suggestion->id, 'read']) }}">{{ __('Mark as read') }}</a>
                @else
                <p><i> {{ __('Marked read') }} </i> &nbsp;&nbsp; <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-warning" href="{{ route('suggestion.markReadUnread', [$suggestion->id, 'unread']) }}">{{ __('Unmark') }}</a></p>
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