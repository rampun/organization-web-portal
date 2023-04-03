@extends('layout.app')

@section('content')

<?php

$jobOptions = [
  "Accounting",
  "Cashier",
  "Cleaner",
  "Clerk",
  "Computer and Information Technology",
  "Construction/Survey",
  "Cook / Waiter",
  "Customer Service",
  "Delivery Worker",
  "Design / Draftsworker",
  "Domestic Helper",
  "Driver",
  "Engineering",
  "Labourer",
  "Management / Administration",
  "Marketing Representative / Sales ",
  "Merchandiser",
  "Office Assistant",
  "Production / Factory ",
  "Receptionist ",
  "Secretary",
  "Security Guard",
  "Stockkeeper",
  "Teacher / Tutor",
  "Technician",
  "Tour Guide",
  "Typist",
  "Other Professional/Associate Professional",
  "Others"
];

?>



<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __("Add New Member") }}</h1>
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

      <form method="POST" action="{{ url('member/create') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <h5 class="text-gray-800"> Primary Information</h5>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="email">
              Email *
              @if ($errors->has('email'))
              <span class="text-danger">({{ $errors->first('email') }})</span>
              @endif
            </label>
            <input type="email" placeholder="example@example.com" value="{{ old('email') }}" name="email" class="form-control" id="email">
          </div>

          <div class="form-group col-md-1">
          </div>
          <div class="form-group col-md-7">
            <i>{{ __('Note: The default password will be the document number without special characters. For e.g. A123456(7) would be A1234567') }} </i>
          </div>

          {{-- <div class="form-group col-md-4">
                <label for="password1">Password *
                  @if ($errors->has('password1'))
                  <span class="text-danger">({{ $errors->first('password1') }})</span>
          @endif

          </label>
          <input type="password" name="password1" value="{{ old('password1') }}" class="form-control" id="password1">
        </div>

        <div class="form-group col-md-4">
          <label for="password2">
            Confirm Password *
            @if ($errors->has('password2'))
            <span class="text-danger">({{ $errors->first('password2') }})</span>
            @endif</label>
          <input type="password" name="password2" value="{{ old('password2') }}" class="form-control" id="password2">
        </div> --}}
    </div>


    <br>
    <h5 class="text-gray-800"> Personal Information</h5>
    <div class="form-row">
      {{-- Member Type --}}
      <div class="form-group col-md-3">
        <label for="membership_type">
          Membership Type *
          @if ($errors->has('membership_type'))
          <span class="text-danger">({{ $errors->first('membership_type') }})</span>
          @endif
        </label>
        <select id="membership_type" name="membership_type" class="form-control">
          <option value="">Select</option>
          <option value="General" @php echo old('membership_type')=='General' ? 'selected' :''; @endphp>General</option>
          <option value="Life Time Member" @php echo old('membership_type')=='Life Time Member' ? 'selected' :''; @endphp>Life Time Member</option>
        </select>
      </div>

      {{-- Membership Type --}}
      <div class="form-group col-md-3">
        <label for="membership">
          Membership No *
          @if ($errors->has('membership_no'))
          <span class="text-danger">({{ $errors->first('membership_no') }})</span>
          @endif
        </label>
        <input type="text" name="membership_no" value="{{ old('membership_no') }}" class="form-control" id="membership">
      </div>

      {{-- Issue Date --}}
      <div class="form-group col-md-3">
        <label for="issue_date">
          Issue Date *
          @if ($errors->has('issue_date'))
          <span class="text-danger">({{ $errors->first('issue_date') }})</span>
          @endif
        </label>
        <input type="text" name="issue_date" value="{{ old('issue_date') }}" class="form-control custom_date_picker" id="issue_date">
      </div>

      {{-- Expiry Date --}}
      <div class="form-group col-md-3">
        <label for="expiry_date">Expiry Date</label>
        <input type="text" name="expiry_date" value="{{ old('expiry_date') }}" class="form-control custom_date_picker" id="expiry_date">
      </div>
    </div>

    <div class="form-row">

      <div class="form-group col-md-4">
        <label for="family_name">
          Family Name
          @if ($errors->has('family_name'))
          <span class="text-danger">({{ $errors->first('family_name') }})</span>
          @endif
        </label>
        <input type="text" name="family_name" value="{{ old('family_name') }}" class="form-control" id="family_name">
      </div>
      <div class="form-group col-md-8">
        <label for="full_name">
          Full Name *
          @if ($errors->has('name'))
          <span class="text-danger">({{ $errors->first('name') }})</span>
          @endif
        </label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="full_name">
      </div>
    </div>

    <h6> Hong Kong </h6>
    <div class="form-row">

      {{-- Address --}}
      <div class="form-group col-md-6">
        <label for="address_hk">
          Address
          @if ($errors->has('address_hk'))
          <span class="text-danger">({{ $errors->first('address_hk') }})</span>
          @endif
        </label>
        <input type="text" name="address_hk" value="{{ old('address_hk') }}" placeholder="Address" class="form-control" id="address_hk">
      </div>

      {{-- Region --}}
      <div class="form-group col-md-3">
        <label for="region_hk">
          Region
          @if ($errors->has('region_hk'))
          <span class="text-danger">({{ $errors->first('region_hk') }})</span>
          @endif
        </label>
        <select id="region_hk" name="region_hk" class="form-control">
          <option value="">Select</option>
          {{-- load regions from json data --}}
          @php if(!empty($hk_regions))
          foreach ($hk_regions as $key => $hk_region) {
          $selected = old("region_hk") == $key ? "selected":"";
          echo '<option value="'.$key.'"' . $selected .' id="'.str_replace(' ', '', $key).'">'. $key . '</option>';
          }
          @endphp
        </select>
      </div>

      {{-- District --}}
      <div class="form-group col-md-3">
        <label for="district_hk">
          District
          @if ($errors->has('district_hk'))
          <span class="text-danger">({{ $errors->first('district_hk') }})</span>
          @endif
        </label>
        <select id="district_hk" name="district_hk" class="form-control">
          <option value="">Select</option>

          @php if(!empty($hk_regions))
          foreach ($hk_regions as $key => $hk_region) {

          foreach ($hk_region as $dis_key => $district) {
          $selected = old("district_hk") == $district ? "selected":"";

          echo '<option value="'.$district.'"' . $selected . ' class="hk_districts '.str_replace(' ', '', $key).'">'. $district . '</option>';
          }
          }
          @endphp
        </select>
      </div>
    </div>

    <div class="form-row">
      {{-- Documnt Type --}}
      <div class="form-group col-md-2">
        <label for="document_type">
          Document Type *
          @if ($errors->has('document_type'))
          <span class="text-danger">({{ $errors->first('document_type') }})</span>
          @endif
        </label>
        <select id="document_type" name="document_type" class="form-control">
          <option value="">Select</option>
          <option value="HKID" @php echo old('document_type')=='HKID' ? 'selected' :''; @endphp>HKID</option>
          <option value="Birth Certificate" @php echo old('document_type')=='Birth Certificate' ? 'selected' :''; @endphp>Birth Certificate</option>
          <option value="Passport" @php echo old('document_type')=='Passport' ? 'selected' :''; @endphp>Passport</option>
        </select>
      </div>

      {{-- Document Number --}}
      <div class="form-group col-md-4">
        <label for="document">
          Document No *
          @if ($errors->has('document_no'))
          <span class="text-danger">({{ $errors->first('document_no') }})</span>
          @endif
        </label>
        <input type="text" name="document_no" value="{{ old('document_no') }}" class="form-control" id="document">
      </div>

      {{-- Telephone Number --}}
      <div class="form-group col-md-3">
        <label for="telephone">Telephone No</label>
        <input type="text" placeholder="xxxxxxxx" value="{{ old('telephone_no') }}" name="telephone_no" class="form-control" id="telephone">
      </div>

      {{-- Mobile Number --}}
      <div class="form-group col-md-3">
        <label for="mobile">
          Mobile No
          @if ($errors->has('mobile_no'))
          <span class="text-danger">({{ $errors->first('mobile_no') }})</span>
          @endif
        </label>
        <input type="text" placeholder="xxxxxxxx" value="{{ old('mobile_no') }}" name="mobile_no" class="form-control" id="mobile">
      </div>
    </div>

    <div class="form-row">
      {{-- Job --}}
      <div class="form-group col-md-4">
        <label for="job">
          Job
          @if ($errors->has('job'))
          <span class="text-danger">({{ $errors->first('job') }})</span>
          @endif</label>

        <select id="job" name="job" class="form-control">
          <option value="">Select</option>
          <?php
          foreach ($jobOptions as $jobOption) {
          ?>
            <option value="<?php echo $jobOption; ?>" <?php echo old('job') == '<?php echo $jobOption;?>' ? 'selected' : ''; ?>><?php echo $jobOption; ?></option>

          <?php } ?>

        </select>
      </div>

      {{-- Member Photo --}}
      <div class="form-group col-md-4">
        <label for="member_photo">Photo</label>
        <input type="file" name="member_photo" value="{{ old('member_photo') }}" class="form-control" id="member_photo">
      </div>
    </div>


    {{-- Add Member Button--}}
    <button type="submit" class="btn btn-sm btn-success">{{ __('Save') }}</button>
    </form>
  </div>
</div>
</div>

@endsection