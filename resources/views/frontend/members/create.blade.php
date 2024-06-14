@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.member.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.members.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.member.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.member.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name_mal">{{ trans('cruds.member.fields.name_mal') }}</label>
                            <input class="form-control" type="text" name="name_mal" id="name_mal" value="{{ old('name_mal', '') }}">
                            @if($errors->has('name_mal'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name_mal') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.member.fields.name_mal_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.member.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Member::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.member.fields.status_helper') }}</span>
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