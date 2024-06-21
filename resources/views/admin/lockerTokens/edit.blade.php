@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.lockerToken.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.locker-tokens.update", [$lockerToken->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="token">{{ trans('cruds.lockerToken.fields.token') }}</label>
                <input class="form-control {{ $errors->has('token') ? 'is-invalid' : '' }}" type="text" name="token" id="token" value="{{ old('token', $lockerToken->token) }}">
                @if($errors->has('token'))
                    <span class="text-danger">{{ $errors->first('token') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.lockerToken.fields.token_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('enabled') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="enabled" value="0">
                    <input class="form-check-input" type="checkbox" name="enabled" id="enabled" value="1" {{ $lockerToken->enabled || old('enabled', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="enabled">{{ trans('cruds.lockerToken.fields.enabled') }}</label>
                </div>
                @if($errors->has('enabled'))
                    <span class="text-danger">{{ $errors->first('enabled') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.lockerToken.fields.enabled_helper') }}</span>
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