@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.country.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.countries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="country_abbr">{{ trans('cruds.country.fields.country_abbr') }}</label>
                <input class="form-control {{ $errors->has('country_abbr') ? 'is-invalid' : '' }}" type="text" name="country_abbr" id="country_abbr" value="{{ old('country_abbr', '') }}" required>
                @if($errors->has('country_abbr'))
                    <span class="text-danger">{{ $errors->first('country_abbr') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.country_abbr_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="country_name">{{ trans('cruds.country.fields.country_name') }}</label>
                <input class="form-control {{ $errors->has('country_name') ? 'is-invalid' : '' }}" type="text" name="country_name" id="country_name" value="{{ old('country_name', '') }}" required>
                @if($errors->has('country_name'))
                    <span class="text-danger">{{ $errors->first('country_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.country_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="iso_3">{{ trans('cruds.country.fields.iso_3') }}</label>
                <input class="form-control {{ $errors->has('iso_3') ? 'is-invalid' : '' }}" type="text" name="iso_3" id="iso_3" value="{{ old('iso_3', '') }}">
                @if($errors->has('iso_3'))
                    <span class="text-danger">{{ $errors->first('iso_3') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.iso_3_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="numcode">{{ trans('cruds.country.fields.numcode') }}</label>
                <input class="form-control {{ $errors->has('numcode') ? 'is-invalid' : '' }}" type="text" name="numcode" id="numcode" value="{{ old('numcode', '') }}">
                @if($errors->has('numcode'))
                    <span class="text-danger">{{ $errors->first('numcode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.numcode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="default_country">{{ trans('cruds.country.fields.default_country') }}</label>
                <input class="form-control {{ $errors->has('default_country') ? 'is-invalid' : '' }}" type="text" name="default_country" id="default_country" value="{{ old('default_country', '') }}">
                @if($errors->has('default_country'))
                    <span class="text-danger">{{ $errors->first('default_country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.default_country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="iso">{{ trans('cruds.country.fields.iso') }}</label>
                <input class="form-control {{ $errors->has('iso') ? 'is-invalid' : '' }}" type="text" name="iso" id="iso" value="{{ old('iso', '') }}">
                @if($errors->has('iso'))
                    <span class="text-danger">{{ $errors->first('iso') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.iso_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phonecode">{{ trans('cruds.country.fields.phonecode') }}</label>
                <input class="form-control {{ $errors->has('phonecode') ? 'is-invalid' : '' }}" type="text" name="phonecode" id="phonecode" value="{{ old('phonecode', '') }}">
                @if($errors->has('phonecode'))
                    <span class="text-danger">{{ $errors->first('phonecode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.phonecode_helper') }}</span>
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