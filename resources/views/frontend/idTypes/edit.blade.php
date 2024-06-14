@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.idType.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.id-types.update", [$idType->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.idType.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $idType->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.idType.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="min_length">{{ trans('cruds.idType.fields.min_length') }}</label>
                            <input class="form-control" type="number" name="min_length" id="min_length" value="{{ old('min_length', $idType->min_length) }}" step="1">
                            @if($errors->has('min_length'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('min_length') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.idType.fields.min_length_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="max_length">{{ trans('cruds.idType.fields.max_length') }}</label>
                            <input class="form-control" type="number" name="max_length" id="max_length" value="{{ old('max_length', $idType->max_length) }}" step="1">
                            @if($errors->has('max_length'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_length') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.idType.fields.max_length_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="regex">{{ trans('cruds.idType.fields.regex') }}</label>
                            <input class="form-control" type="text" name="regex" id="regex" value="{{ old('regex', $idType->regex) }}">
                            @if($errors->has('regex'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('regex') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.idType.fields.regex_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name_mal">{{ trans('cruds.idType.fields.name_mal') }}</label>
                            <input class="form-control" type="text" name="name_mal" id="name_mal" value="{{ old('name_mal', $idType->name_mal) }}">
                            @if($errors->has('name_mal'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name_mal') }}
                                </div>
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

        </div>
    </div>
</div>
@endsection