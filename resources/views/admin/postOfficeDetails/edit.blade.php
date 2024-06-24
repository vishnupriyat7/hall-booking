@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.postOfficeDetail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.post-office-details.update", [$postOfficeDetail->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="pincode">{{ trans('cruds.postOfficeDetail.fields.pincode') }}</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', $postOfficeDetail->pincode) }}">
                @if($errors->has('pincode'))
                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="default_post_flag">{{ trans('cruds.postOfficeDetail.fields.default_post_flag') }}</label>
                <input class="form-control {{ $errors->has('default_post_flag') ? 'is-invalid' : '' }}" type="text" name="default_post_flag" id="default_post_flag" value="{{ old('default_post_flag', $postOfficeDetail->default_post_flag) }}">
                @if($errors->has('default_post_flag'))
                    <span class="text-danger">{{ $errors->first('default_post_flag') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.default_post_flag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_office_name">{{ trans('cruds.postOfficeDetail.fields.post_office_name') }}</label>
                <input class="form-control {{ $errors->has('post_office_name') ? 'is-invalid' : '' }}" type="text" name="post_office_name" id="post_office_name" value="{{ old('post_office_name', $postOfficeDetail->post_office_name) }}">
                @if($errors->has('post_office_name'))
                    <span class="text-danger">{{ $errors->first('post_office_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.post_office_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_office_status">{{ trans('cruds.postOfficeDetail.fields.post_office_status') }}</label>
                <input class="form-control {{ $errors->has('post_office_status') ? 'is-invalid' : '' }}" type="text" name="post_office_status" id="post_office_status" value="{{ old('post_office_status', $postOfficeDetail->post_office_status) }}">
                @if($errors->has('post_office_status'))
                    <span class="text-danger">{{ $errors->first('post_office_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.post_office_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state_id">{{ trans('cruds.postOfficeDetail.fields.state') }}</label>
                <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state_id" id="state_id">
                    @foreach($states as $id => $entry)
                        <option value="{{ $id }}" {{ (old('state_id') ? old('state_id') : $postOfficeDetail->state->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district_id">{{ trans('cruds.postOfficeDetail.fields.district') }}</label>
                <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}" name="district_id" id="district_id">
                    @foreach($districts as $id => $entry)
                        <option value="{{ $id }}" {{ (old('district_id') ? old('district_id') : $postOfficeDetail->district->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('district'))
                    <span class="text-danger">{{ $errors->first('district') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district_name">{{ trans('cruds.postOfficeDetail.fields.district_name') }}</label>
                <input class="form-control {{ $errors->has('district_name') ? 'is-invalid' : '' }}" type="text" name="district_name" id="district_name" value="{{ old('district_name', $postOfficeDetail->district_name) }}">
                @if($errors->has('district_name'))
                    <span class="text-danger">{{ $errors->first('district_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.district_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="postal_circle">{{ trans('cruds.postOfficeDetail.fields.postal_circle') }}</label>
                <input class="form-control {{ $errors->has('postal_circle') ? 'is-invalid' : '' }}" type="text" name="postal_circle" id="postal_circle" value="{{ old('postal_circle', $postOfficeDetail->postal_circle) }}">
                @if($errors->has('postal_circle'))
                    <span class="text-danger">{{ $errors->first('postal_circle') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postOfficeDetail.fields.postal_circle_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection