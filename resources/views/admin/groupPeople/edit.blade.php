@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.groupPerson.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.group-people.update", [$groupPerson->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.groupPerson.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $groupPerson->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.groupPerson.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age">{{ trans('cruds.groupPerson.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="text" name="age" id="age" value="{{ old('age', $groupPerson->age) }}">
                @if($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.groupPerson.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.groupPerson.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\GroupPerson::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', $groupPerson->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.groupPerson.fields.gender_helper') }}</span>
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