@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.idType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.id-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.idType.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.idType.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="min_length">{{ trans('cruds.idType.fields.min_length') }}</label>
                <input class="form-control {{ $errors->has('min_length') ? 'is-invalid' : '' }}" type="number" name="min_length" id="min_length" value="{{ old('min_length', '') }}" step="1">
                @if($errors->has('min_length'))
                    <span class="text-danger">{{ $errors->first('min_length') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.idType.fields.min_length_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="max_length">{{ trans('cruds.idType.fields.max_length') }}</label>
                <input class="form-control {{ $errors->has('max_length') ? 'is-invalid' : '' }}" type="number" name="max_length" id="max_length" value="{{ old('max_length', '') }}" step="1">
                @if($errors->has('max_length'))
                    <span class="text-danger">{{ $errors->first('max_length') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.idType.fields.max_length_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="regex">{{ trans('cruds.idType.fields.regex') }}</label>
                <input class="form-control {{ $errors->has('regex') ? 'is-invalid' : '' }}" type="text" name="regex" id="regex" value="{{ old('regex', '') }}">
                @if($errors->has('regex'))
                    <span class="text-danger">{{ $errors->first('regex') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.idType.fields.regex_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name_mal">{{ trans('cruds.idType.fields.name_mal') }}</label>
                <input class="form-control {{ $errors->has('name_mal') ? 'is-invalid' : '' }}" type="text" name="name_mal" id="name_mal" value="{{ old('name_mal', '') }}">
                @if($errors->has('name_mal'))
                    <span class="text-danger">{{ $errors->first('name_mal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.idType.fields.name_mal_helper') }}</span>
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