@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.guidingOfficer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.guiding-officers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.guidingOfficer.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.guidingOfficer.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pen">{{ trans('cruds.guidingOfficer.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', '') }}" required>
                @if($errors->has('pen'))
                    <span class="text-danger">{{ $errors->first('pen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.guidingOfficer.fields.pen_helper') }}</span>
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