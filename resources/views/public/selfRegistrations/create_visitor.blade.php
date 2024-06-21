@extends('layouts.pub')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        KERALA LEGISLATIVE ASSEMBLY<br>
        VisitorPass {{ trans('cruds.selfRegistration.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('public.self-registrations.store_visitor') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.selfRegistration.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.selfRegistration.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender" required>
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SelfRegistration::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="dob">Date of Birth</label>
                <input id="startDate" class="form-control" name="dob" id="dob" type="date" required/>

                @if($errors->has('dob'))
                    <span class="text-danger">{{ $errors->first('dob') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="mobile">{{ trans('cruds.selfRegistration.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', '') }}" required>
                @if($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="id_type_id">ID Card Type</label>
                <select class="form-control {{ $errors->has('id_type') ? 'is-invalid' : '' }}" name="id_type_id" id="id_type_id" required>
                    @foreach($id_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('id_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_type'))
                    <span class="text-danger">{{ $errors->first('id_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.id_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="id_detail">ID Card Number</label>
                <input class="form-control {{ $errors->has('id_detail') ? 'is-invalid' : '' }}" type="text" name="id_detail" id="id_detail" value="{{ old('id_detail', '') }}" required>
                @if($errors->has('id_detail'))
                    <span class="text-danger">{{ $errors->first('id_detail') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.id_detail_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.selfRegistration.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address" required>{{ old('address') }}</textarea>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.address_helper') }}</span>
            </div>


            <div class="form-group">
                <label class="required">{{ trans('cruds.selfRegistration.fields.country') }}</label>
                <select class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" id="country" required>
                    <option value disabled {{ old('country', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SelfRegistration::COUNTRY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('country', '76') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="state">{{ trans('cruds.selfRegistration.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', '') }}" required>
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district">{{ trans('cruds.selfRegistration.fields.district') }}</label>
                <input required class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', '') }}">
                @if($errors->has('district'))
                    <span class="text-danger">{{ $errors->first('district') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pincode">PIN</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', '') }}" required>
                @if($errors->has('pincode'))
                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_office">{{ trans('cruds.selfRegistration.fields.post_office') }}</label>
                <input  class="form-control {{ $errors->has('post_office') ? 'is-invalid' : '' }}" type="text" name="post_office" id="post_office" value="{{ old('post_office', '') }}">
                @if($errors->has('post_office'))
                    <span class="text-danger">{{ $errors->first('post_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.post_office_helper') }}</span>
            </div>

            <input type="hidden" name="pass_type" value="visit">


            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                        Submit
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>

</script>


@endsection
