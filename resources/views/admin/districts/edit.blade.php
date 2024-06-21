@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.district.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.districts.update", [$district->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="state_cd_id">{{ trans('cruds.district.fields.state_cd') }}</label>
                <select class="form-control select2 {{ $errors->has('state_cd') ? 'is-invalid' : '' }}" name="state_cd_id" id="state_cd_id">
                    @foreach($state_cds as $id => $entry)
                        <option value="{{ $id }}" {{ (old('state_cd_id') ? old('state_cd_id') : $district->state_cd->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('state_cd'))
                    <span class="text-danger">{{ $errors->first('state_cd') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.district.fields.state_cd_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district_abbr">{{ trans('cruds.district.fields.district_abbr') }}</label>
                <input class="form-control {{ $errors->has('district_abbr') ? 'is-invalid' : '' }}" type="text" name="district_abbr" id="district_abbr" value="{{ old('district_abbr', $district->district_abbr) }}">
                @if($errors->has('district_abbr'))
                    <span class="text-danger">{{ $errors->first('district_abbr') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.district.fields.district_abbr_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district_name">{{ trans('cruds.district.fields.district_name') }}</label>
                <input class="form-control {{ $errors->has('district_name') ? 'is-invalid' : '' }}" type="text" name="district_name" id="district_name" value="{{ old('district_name', $district->district_name) }}">
                @if($errors->has('district_name'))
                    <span class="text-danger">{{ $errors->first('district_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.district.fields.district_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pin_code">{{ trans('cruds.district.fields.pin_code') }}</label>
                <input class="form-control {{ $errors->has('pin_code') ? 'is-invalid' : '' }}" type="text" name="pin_code" id="pin_code" value="{{ old('pin_code', $district->pin_code) }}">
                @if($errors->has('pin_code'))
                    <span class="text-danger">{{ $errors->first('pin_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.district.fields.pin_code_helper') }}</span>
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