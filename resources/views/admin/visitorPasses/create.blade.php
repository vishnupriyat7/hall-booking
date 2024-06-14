@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.visitorPass.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.visitor-passes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="number">{{ trans('cruds.visitorPass.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1" required>
                @if($errors->has('number'))
                    <span class="text-danger">{{ $errors->first('number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="person_id">{{ trans('cruds.visitorPass.fields.person') }}</label>
                <select class="form-control select2 {{ $errors->has('person') ? 'is-invalid' : '' }}" name="person_id" id="person_id" required>
                    @foreach($people as $id => $entry)
                        <option value="{{ $id }}" {{ old('person_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('person'))
                    <span class="text-danger">{{ $errors->first('person') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.person_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pass_valid_from">{{ trans('cruds.visitorPass.fields.pass_valid_from') }}</label>
                <input class="form-control datetime {{ $errors->has('pass_valid_from') ? 'is-invalid' : '' }}" type="text" name="pass_valid_from" id="pass_valid_from" value="{{ old('pass_valid_from') }}">
                @if($errors->has('pass_valid_from'))
                    <span class="text-danger">{{ $errors->first('pass_valid_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.pass_valid_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pass_valid_upto">{{ trans('cruds.visitorPass.fields.pass_valid_upto') }}</label>
                <input class="form-control datetime {{ $errors->has('pass_valid_upto') ? 'is-invalid' : '' }}" type="text" name="pass_valid_upto" id="pass_valid_upto" value="{{ old('pass_valid_upto') }}">
                @if($errors->has('pass_valid_upto'))
                    <span class="text-danger">{{ $errors->first('pass_valid_upto') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.pass_valid_upto_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="issued_date">{{ trans('cruds.visitorPass.fields.issued_date') }}</label>
                <input class="form-control date {{ $errors->has('issued_date') ? 'is-invalid' : '' }}" type="text" name="issued_date" id="issued_date" value="{{ old('issued_date') }}">
                @if($errors->has('issued_date'))
                    <span class="text-danger">{{ $errors->first('issued_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.issued_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_visit">{{ trans('cruds.visitorPass.fields.date_of_visit') }}</label>
                <input class="form-control date {{ $errors->has('date_of_visit') ? 'is-invalid' : '' }}" type="text" name="date_of_visit" id="date_of_visit" value="{{ old('date_of_visit') }}">
                @if($errors->has('date_of_visit'))
                    <span class="text-danger">{{ $errors->first('date_of_visit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.date_of_visit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.visitorPass.fields.purpose') }}</label>
                <select class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose" id="purpose" required>
                    <option value disabled {{ old('purpose', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VisitorPass::PURPOSE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('purpose', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('purpose'))
                    <span class="text-danger">{{ $errors->first('purpose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.purpose_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="visiting_office_category_id">{{ trans('cruds.visitorPass.fields.visiting_office_category') }}</label>
                <select class="form-control select2 {{ $errors->has('visiting_office_category') ? 'is-invalid' : '' }}" name="visiting_office_category_id" id="visiting_office_category_id">
                    @foreach($visiting_office_categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('visiting_office_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('visiting_office_category'))
                    <span class="text-danger">{{ $errors->first('visiting_office_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.visiting_office_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="visiting_office">{{ trans('cruds.visitorPass.fields.visiting_office') }}</label>
                <input class="form-control {{ $errors->has('visiting_office') ? 'is-invalid' : '' }}" type="text" name="visiting_office" id="visiting_office" value="{{ old('visiting_office', '') }}">
                @if($errors->has('visiting_office'))
                    <span class="text-danger">{{ $errors->first('visiting_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.visiting_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="recommending_office_category_id">{{ trans('cruds.visitorPass.fields.recommending_office_category') }}</label>
                <select class="form-control select2 {{ $errors->has('recommending_office_category') ? 'is-invalid' : '' }}" name="recommending_office_category_id" id="recommending_office_category_id">
                    @foreach($recommending_office_categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('recommending_office_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('recommending_office_category'))
                    <span class="text-danger">{{ $errors->first('recommending_office_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.recommending_office_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="recommending_office">{{ trans('cruds.visitorPass.fields.recommending_office') }}</label>
                <input class="form-control {{ $errors->has('recommending_office') ? 'is-invalid' : '' }}" type="text" name="recommending_office" id="recommending_office" value="{{ old('recommending_office', '') }}">
                @if($errors->has('recommending_office'))
                    <span class="text-danger">{{ $errors->first('recommending_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visitorPass.fields.recommending_office_helper') }}</span>
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