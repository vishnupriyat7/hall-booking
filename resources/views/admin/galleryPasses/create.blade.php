@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.galleryPass.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.gallery-passes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="number">{{ trans('cruds.galleryPass.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1" required>
                @if($errors->has('number'))
                    <span class="text-danger">{{ $errors->first('number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="person_id">{{ trans('cruds.galleryPass.fields.person') }}</label>
                <select class="form-control select2 {{ $errors->has('person') ? 'is-invalid' : '' }}" name="person_id" id="person_id" required>
                    @foreach($people as $id => $entry)
                        <option value="{{ $id }}" {{ old('person_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('person'))
                    <span class="text-danger">{{ $errors->first('person') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.person_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="issued_date">{{ trans('cruds.galleryPass.fields.issued_date') }}</label>
                <input class="form-control date {{ $errors->has('issued_date') ? 'is-invalid' : '' }}" type="text" name="issued_date" id="issued_date" value="{{ old('issued_date') }}">
                @if($errors->has('issued_date'))
                    <span class="text-danger">{{ $errors->first('issued_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.issued_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_visit">{{ trans('cruds.galleryPass.fields.date_of_visit') }}</label>
                <input class="form-control date {{ $errors->has('date_of_visit') ? 'is-invalid' : '' }}" type="text" name="date_of_visit" id="date_of_visit" value="{{ old('date_of_visit') }}">
                @if($errors->has('date_of_visit'))
                    <span class="text-danger">{{ $errors->first('date_of_visit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.date_of_visit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="guide_id">{{ trans('cruds.galleryPass.fields.guide') }}</label>
                <select class="form-control select2 {{ $errors->has('guide') ? 'is-invalid' : '' }}" name="guide_id" id="guide_id">
                    @foreach($guides as $id => $entry)
                        <option value="{{ $id }}" {{ old('guide_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('guide'))
                    <span class="text-danger">{{ $errors->first('guide') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.guide_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="print_count">{{ trans('cruds.galleryPass.fields.print_count') }}</label>
                <input class="form-control {{ $errors->has('print_count') ? 'is-invalid' : '' }}" type="number" name="print_count" id="print_count" value="{{ old('print_count', '') }}" step="1">
                @if($errors->has('print_count'))
                    <span class="text-danger">{{ $errors->first('print_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.print_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_type">{{ trans('cruds.galleryPass.fields.id_type') }}</label>
                <input class="form-control {{ $errors->has('id_type') ? 'is-invalid' : '' }}" type="text" name="id_type" id="id_type" value="{{ old('id_type', '') }}">
                @if($errors->has('id_type'))
                    <span class="text-danger">{{ $errors->first('id_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.id_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_detail">{{ trans('cruds.galleryPass.fields.id_detail') }}</label>
                <input class="form-control {{ $errors->has('id_detail') ? 'is-invalid' : '' }}" type="text" name="id_detail" id="id_detail" value="{{ old('id_detail', '') }}">
                @if($errors->has('id_detail'))
                    <span class="text-danger">{{ $errors->first('id_detail') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.id_detail_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.galleryPass.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address') }}</textarea>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country">{{ trans('cruds.galleryPass.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}">
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state">{{ trans('cruds.galleryPass.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', '') }}">
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district">{{ trans('cruds.galleryPass.fields.district') }}</label>
                <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', '') }}">
                @if($errors->has('district'))
                    <span class="text-danger">{{ $errors->first('district') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_office">{{ trans('cruds.galleryPass.fields.post_office') }}</label>
                <input class="form-control {{ $errors->has('post_office') ? 'is-invalid' : '' }}" type="text" name="post_office" id="post_office" value="{{ old('post_office', '') }}">
                @if($errors->has('post_office'))
                    <span class="text-danger">{{ $errors->first('post_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.post_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pincode">{{ trans('cruds.galleryPass.fields.pincode') }}</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', '') }}">
                @if($errors->has('pincode'))
                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.galleryPass.fields.photo') }}</label>
                <input class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}" type="text" name="photo" id="photo" value="{{ old('photo', '') }}">
                @if($errors->has('photo'))
                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.galleryPass.fields.photo_helper') }}</span>
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