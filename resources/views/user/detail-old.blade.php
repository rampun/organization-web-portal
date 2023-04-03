@extends('layout.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <br />
            <h5> {{ $user->name }}
                &nbsp;
                <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-success" href="{{ route('member.update',$user['id']) }}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                    &nbsp;
                    {{ __('Edit') }}
                </a>

            </h5>
        </div>
        <div class="col-md-12">
            @php
            if(!empty($user_info->member_photo))
            echo '<img src="'. $user_info->member_photo .'" width="150px">';
            else
            echo '<img src="'. Helper::getPlaceholderImage() .'" width="150px">';
            @endphp
        </div>
    </div>


    <br>
    {{-- Membrship Information --}}
    <div style="border-bottom: 1px solid gainsboro">
        <h5 class="upperTitle" style="text-transform: uppercase"> Membership Information</h5>
        <div class="form-row">
            <div class="form-group col-md-3">
                <strong>Type:</strong>
                @php
                if(!empty($user_info->membership_type))
                echo $user_info->membership_type;
                @endphp
            </div>
            <div class="form-group col-md-3">
                <strong>Number:</strong>
                @php
                if(!empty($user_info->membership_no))
                echo $user_info->membership_no;
                @endphp
            </div>
            <div class="form-group col-md-3">
                <strong>Issue Date:</strong>
                @php
                if(!empty($user_info->issue_date))
                echo $user_info->issue_date;
                @endphp
            </div>

            @php if(!empty($user_info->expiry_date))
            {
            echo '<div class="form-group col-md-3">
                <strong>Expiry Date: </strong>';
                if(!empty($user_info->issue_date))
                echo $user_info->expiry_date;
                echo '
            </div>';
            }
            @endphp
        </div>
    </div>

    <br>
    {{-- Personal Information --}}
    <div style="border-bottom: 1px solid gainsboro">
        <h5 class="upperTitle" style="text-transform: uppercase"> Personal Information</h5>
        <div class="form-row">
            <div class="form-group col-md-3">
                <strong>Family Name:</strong>
                @php
                if(!empty($user_info->family_name))
                echo $user_info->family_name;
                @endphp
            </div>
            <div class="form-group col-md-3">
                <strong>E-mail:</strong>
                @php
                if(!empty($user->email))
                echo $user->email;
                @endphp
            </div>
            @php if(!empty($user_info->expiry_date))
            {
            echo '<div class="form-group col-md-3">
                <strong>Telephone: </strong>';
                if(!empty($user_info->telephone_no))
                echo $user_info->telephone_no;
                echo '
            </div>';
            }
            @endphp
            <div class="form-group col-md-3">
                <strong>Mobile:</strong>
                @php
                if(!empty($user_info->mobile_no))
                echo $user_info->mobile_no;
                @endphp
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <strong>Address (Nepal):</strong>
                @php
                if(!empty($user_info->address_np))
                echo $user_info->address_np;
                @endphp
                @php
                if(!empty($user_info->district_np))
                echo ', ' . $user_info->district_np;
                @endphp
                @php
                if(!empty($user_info->province_np))
                echo ', ' . $user_info->province_np;
                @endphp
            </div>

            <div class="form-group col-md-6">
                <strong>Address (Hong Kong):</strong>
                @php
                if(!empty($user_info->address_hk))
                echo $user_info->address_hk;
                @endphp
                @php
                if(!empty($user_info->district_hk))
                echo ', ' . $user_info->district_hk;
                @endphp
                @php
                if(!empty($user_info->region_hk))
                echo ', ' . $user_info->region_hk;
                @endphp
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <strong>Document Type:</strong>
                @php
                if(!empty($user_info->document_type))
                echo $user_info->document_type;
                @endphp
            </div>

            <div class="form-group col-md-3">
                <strong>Document No.:</strong>
                @php
                if(!empty($user_info->document_no))
                echo Crypt::decryptString($user_info->document_no);
                @endphp
            </div>

            <div class="form-group col-md-3">
                <strong>Job:</strong>
                @php
                if(!empty($user_info->job))
                echo $user_info->job;
                @endphp
            </div>
        </div>
    </div>

    <br>
    {{-- Spouse Information --}}
    <?php if (!empty($user_info->spouse_name) || !empty($user_info->spouse_job) || !empty($user_info->spouse_photo)) : ?>
        <div style="border-bottom: 1px solid gainsboro">
            <h5 class="upperTitle" style="text-transform: uppercase"> Spouse Information</h5>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <strong>Name:</strong>
                    @php
                    echo $user_info->spouse_name;
                    @endphp
                </div>

                <div class="form-group col-md-3">
                    <strong>Job:</strong>
                    @php
                    echo $user_info->spouse_job;
                    @endphp
                </div>
                <div class="form-group col-md-3">
                    <strong>Photo:</strong>
                    @php
                    if(!empty($user_info->spouse_photo))
                    echo '<img src="'.$user_info->spouse_photo .'" width="150px">';
                    else {
                    echo '<img src="'. Helper::getPlaceholderImage() . " width='150px'>';
                    }
                    @endphp
                </div>
            </div>
        </div>
    <?php endif; ?>

    {{-- Child Information --}}
    @if (!$children_info->isEmpty())
    <div style="border-bottom: 1px solid gainsboro">
        <h5 class="upperTitle" style="text-transform: uppercase"> Child Information</h5>
        @foreach ($children_info as $child)
        <div class="form-row">
            <div class="form-group col-md-3">
                <strong>Full Name:</strong>
                @php
                if(!empty($child->full_name))
                echo $child->full_name;
                @endphp
            </div>
            <div class="form-group col-md-2">
                <strong>DOB: </strong>
                @php
                if(!empty($child->dob))
                echo $child->dob;
                @endphp
            </div>
            <div class="form-group col-md-2">
                <strong>Gender: </strong>
                @php
                if(!empty($child->gender))
                echo $child->gender;
                @endphp
            </div>

            <div class="form-group col-md-3">
                <strong>Education: </strong>
                @php
                if(!empty($child->education_level))
                echo $child->education_level;
                @endphp
            </div>
            <div class="form-group col-md-2">
                @php
                if(!empty($child->photo))
                echo '<img src="'.URL::to('/').$user->id .'/'.$child->photo .'" width="150px">';
                else {
                echo '<img src="'.URL::to('/').'/images/pmshk-placeholder.jpeg" width="150px">';
                }
                @endphp
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection