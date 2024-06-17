@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.person.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.people.update", [$person->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.person.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $person->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.person.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender" required>
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Person::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', $person->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dob">{{ trans('cruds.person.fields.dob') }}</label>
                <input class="form-control date {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="text" name="dob" id="dob" value="{{ old('dob', $person->dob) }}">
                @if($errors->has('dob'))
                    <span class="text-danger">{{ $errors->first('dob') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.dob_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age">{{ trans('cruds.person.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', $person->age) }}" step="1">
                @if($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mobile">{{ trans('cruds.person.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $person->mobile) }}">
                @if($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.person.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $person->email) }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_type_id">{{ trans('cruds.person.fields.id_type') }}</label>
                <select class="form-control select2 {{ $errors->has('id_type') ? 'is-invalid' : '' }}" name="id_type_id" id="id_type_id">
                    @foreach($id_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('id_type_id') ? old('id_type_id') : $person->id_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_type'))
                    <span class="text-danger">{{ $errors->first('id_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.id_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="id_detail">{{ trans('cruds.person.fields.id_detail') }}</label>
                <input class="form-control {{ $errors->has('id_detail') ? 'is-invalid' : '' }}" type="text" name="id_detail" id="id_detail" value="{{ old('id_detail', $person->id_detail) }}">
                @if($errors->has('id_detail'))
                    <span class="text-danger">{{ $errors->first('id_detail') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.id_detail_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.person.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address', $person->address) }}</textarea>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country">{{ trans('cruds.person.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', $person->country) }}">
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state">{{ trans('cruds.person.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', $person->state) }}">
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district">{{ trans('cruds.person.fields.district') }}</label>
                <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', $person->district) }}">
                @if($errors->has('district'))
                    <span class="text-danger">{{ $errors->first('district') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_office">{{ trans('cruds.person.fields.post_office') }}</label>
                <input class="form-control {{ $errors->has('post_office') ? 'is-invalid' : '' }}" type="text" name="post_office" id="post_office" value="{{ old('post_office', $person->post_office) }}">
                @if($errors->has('post_office'))
                    <span class="text-danger">{{ $errors->first('post_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.post_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pincode">{{ trans('cruds.person.fields.pincode') }}</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', $person->pincode) }}">
                @if($errors->has('pincode'))
                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.person.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.photo_helper') }}</span>
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
    url: '{{ route('admin.people.storeMedia') }}',
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
@if(isset($person) && $person->photo)
      var file = {!! json_encode($person->photo) !!}
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