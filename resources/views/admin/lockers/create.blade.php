@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.locker.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.lockers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="pass_id">{{ trans('cruds.locker.fields.pass') }}</label>
                <select class="form-control select2 {{ $errors->has('pass') ? 'is-invalid' : '' }}" name="pass_id" id="pass_id">
                    @foreach($passes as $id => $entry)
                        <option value="{{ $id }}" {{ old('pass_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('pass'))
                    <span class="text-danger">{{ $errors->first('pass') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.locker.fields.pass_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="token">{{ trans('cruds.locker.fields.token') }}</label>
                <input class="form-control {{ $errors->has('token') ? 'is-invalid' : '' }}" type="text" name="token" id="token" value="{{ old('token', '') }}">
                @if($errors->has('token'))
                    <span class="text-danger">{{ $errors->first('token') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.locker.fields.token_helper') }}</span>
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