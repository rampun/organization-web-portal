{{-- injecting the User Trait on view --}}
@inject('User', 'App\Http\Controllers\CommitteeController')

@extends('layout.app')

@section('content')

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Departments") }}</h1>
    &nbsp;&nbsp;&nbsp;
    <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('department.create') }}">{{ __('Add New') }}</a>
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
              @php echo route('department.list', 'All')  @endphp
            @endslot
            @slot('allClass')
              @php echo $status=="All" ? "current" : ""; @endphp
            @endslot 
            @slot('allCount')
              @php echo $departmentCount['All']; @endphp
            @endslot

            {{-- Publish post --}}
            @slot('publishRoute')
              @php echo route('department.list', 'Publish')  @endphp
            @endslot
            @slot('publishClass')
              @php echo $status=="Publish" ? "current" : ""; @endphp
            @endslot
            @slot('publishCount')
              @php echo $departmentCount['Publish']; @endphp
            @endslot

            {{-- Draft Post --}}
            @slot('draftRoute')
              @php echo route('department.list', 'Draft')  @endphp
            @endslot
            @slot('draftClass')
              @php echo $status=="Draft" ? "current" : ""; @endphp
            @endslot
            @slot('draftCount')
              @php echo $departmentCount['Draft']; @endphp
            @endslot

            {{-- Trash Post --}}
            @slot('trashRoute')
              @php echo route('department.list', 'Trash')  @endphp
            @endslot
            @slot('trashClass')
              @php echo $status=="Trash" ? "current" : ""; @endphp
            @endslot
            @slot('trashCount')
              @php echo $departmentCount['Trash']; @endphp
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
                <th scope="col">Name</th>
                <th scope="col">Coordinator</th>
                <th scope="col">Contact</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

    @php 
      $i = 1; 
    @endphp

    @foreach ($departments as $department)
    @php
    if(!empty($department->coordinator))
    {
      $coordinator = $User->getUser($department->coordinator);
    }
    @endphp

              <tr>
              <td scope="row">@php echo $i; @endphp </td>
              <td scope="row"> 
                {{ $department->name }}
                @if ($department->status == 'Draft' && $status!='Draft')
                  <span class="post-state"> — Draft</span>
                @endif
              </td>
              <td scope="row">
                <a href="{{ route('member.detail',$coordinator['id']) }} "> {{ $coordinator['name'] }} </a>
              </td>
              <td scope="row">
                {{ $coordinator['mobile_no'] }}
              </td>
              <td>
                @if($status == 'All' || $status == 'Publish' || $status == 'Draft')
                  <a href="{{ route('department.delete',$department->id) }}">
                  Delete
                </a>
              @elseif ($status == 'Trash')
                <a href="{{ route('department.restore',$department->id) }}">
                  Restore
                </a>&nbsp;|&nbsp;
                <a href="{{ route('department.permanentlyDelete',$department->id) }}">
                Delete Permanently
              </a>

              @endif
              </td>

              </tr>

              {{-- adding a sub department --}}
              @if(!empty($department->meta))
                @php
                  $metas = json_decode($department->meta, true);
                  $j = 1;
                  foreach ($metas as $key => $meta) {
                    echo '<tr>';
                    echo '<td>' . ($i * 10 + $j)/10 . '</td>';
                    echo '<td>' . $meta['name'] . '</td>';

                    if(!empty($meta['coordinator']))
                    {
                      $coordin = $User->getUser($meta['coordinator']);
                    }

                    echo '<td> <a href="' . route('member.detail',$coordin['id']) .'">' . $coordin['name'] . '</a></td>';
                    echo '<td>'. $coordinator['mobile_no'] . '</td>';
                    echo '<td></td>';
                    echo '</tr>';
                    $j++;
                  }
                @endphp
              @endif

              @php $i++; @endphp
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection