@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.session.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sessions.update", [$session->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.session.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $session->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $session->active || old('active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.session.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <span class="text-danger">{{ $errors->first('active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.active_helper') }}</span>
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