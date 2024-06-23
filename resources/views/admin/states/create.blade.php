@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.state.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.states.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.state.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state_abbr">{{ trans('cruds.state.fields.state_abbr') }}</label>
                <input class="form-control {{ $errors->has('state_abbr') ? 'is-invalid' : '' }}" type="text" name="state_abbr" id="state_abbr" value="{{ old('state_abbr', '') }}">
                @if($errors->has('state_abbr'))
                    <span class="text-danger">{{ $errors->first('state_abbr') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.state_abbr_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state_name">{{ trans('cruds.state.fields.state_name') }}</label>
                <input class="form-control {{ $errors->has('state_name') ? 'is-invalid' : '' }}" type="text" name="state_name" id="state_name" value="{{ old('state_name', '') }}">
                @if($errors->has('state_name'))
                    <span class="text-danger">{{ $errors->first('state_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.state_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="default_state">{{ trans('cruds.state.fields.default_state') }}</label>
                <input class="form-control {{ $errors->has('default_state') ? 'is-invalid' : '' }}" type="text" name="default_state" id="default_state" value="{{ old('default_state', '') }}">
                @if($errors->has('default_state'))
                    <span class="text-danger">{{ $errors->first('default_state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.default_state_helper') }}</span>
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