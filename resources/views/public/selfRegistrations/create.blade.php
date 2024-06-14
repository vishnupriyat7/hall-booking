@extends('layouts.pub')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.selfRegistration.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("public.self-registrations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.selfRegistration.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.selfRegistration.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender" required>
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SelfRegistration::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="age">{{ trans('cruds.selfRegistration.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', '') }}" step="1" required>
                @if($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mobile">{{ trans('cruds.selfRegistration.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', '') }}" required>
                @if($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_type_id">{{ trans('cruds.selfRegistration.fields.id_type') }}</label>
                <select class="form-control select2 {{ $errors->has('id_type') ? 'is-invalid' : '' }}" name="id_type_id" id="id_type_id">
                    @foreach($id_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('id_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_type'))
                    <span class="text-danger">{{ $errors->first('id_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.id_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_detail">{{ trans('cruds.selfRegistration.fields.id_detail') }}</label>
                <input class="form-control {{ $errors->has('id_detail') ? 'is-invalid' : '' }}" type="text" name="id_detail" id="id_detail" value="{{ old('id_detail', '') }}">
                @if($errors->has('id_detail'))
                    <span class="text-danger">{{ $errors->first('id_detail') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.id_detail_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.selfRegistration.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address') }}</textarea>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.selfRegistration.fields.country') }}</label>
                <select class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" id="country">
                    <!-- <option value disabled {{ old('country', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option> -->
                    @foreach(App\Models\SelfRegistration::COUNTRY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('country', 'India') === (string) $label ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state">{{ trans('cruds.selfRegistration.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', 'Kerala') }}">
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pincode">{{ trans('cruds.selfRegistration.fields.pincode') }}</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', '') }}" required>
                @if($errors->has('pincode'))
                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.selfRegistration.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.selfRegistration.fields.purpose') }}</label>
                <select class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose" id="purpose" required>
                    <option value disabled {{ old('purpose', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SelfRegistration::PURPOSE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('purpose', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('purpose'))
                    <span class="text-danger">{{ $errors->first('purpose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.purpose_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_visit">{{ trans('cruds.selfRegistration.fields.date_of_visit') }}</label>
                <input class="form-control date {{ $errors->has('date_of_visit') ? 'is-invalid' : '' }}" type="text" name="date_of_visit" id="date_of_visit" value="{{ old('date_of_visit') }}">
                @if($errors->has('date_of_visit'))
                    <span class="text-danger">{{ $errors->first('date_of_visit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.date_of_visit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="visiting_office_category_id">{{ trans('cruds.selfRegistration.fields.visiting_office_category') }}</label>
                <select class="form-control select2 {{ $errors->has('visiting_office_category') ? 'is-invalid' : '' }}" name="visiting_office_category_id" id="visiting_office_category_id" required>
                    @foreach($visiting_office_categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('visiting_office_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('visiting_office_category'))
                    <span class="text-danger">{{ $errors->first('visiting_office_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.visiting_office_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="visiting_office_id">{{ trans('cruds.selfRegistration.fields.visiting_office') }}</label>
                <select class="form-control select2 {{ $errors->has('visiting_office') ? 'is-invalid' : '' }}" name="visiting_office_id" id="visiting_office_id" required>
                    @foreach($visiting_offices as $id => $entry)
                        <option value="{{ $id }}" {{ old('visiting_office_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('visiting_office'))
                    <span class="text-danger">{{ $errors->first('visiting_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.visiting_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district">{{ trans('cruds.selfRegistration.fields.district') }}</label>
                <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', '') }}">
                @if($errors->has('district'))
                    <span class="text-danger">{{ $errors->first('district') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_office">{{ trans('cruds.selfRegistration.fields.post_office') }}</label>
                <input class="form-control {{ $errors->has('post_office') ? 'is-invalid' : '' }}" type="text" name="post_office" id="post_office" value="{{ old('post_office', '') }}">
                @if($errors->has('post_office'))
                    <span class="text-danger">{{ $errors->first('post_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.selfRegistration.fields.post_office_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('public.self-registrations.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($selfRegistration) && $selfRegistration->photo)
      var file = {!! json_encode($selfRegistration->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection
