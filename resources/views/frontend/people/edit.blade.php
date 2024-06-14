@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.person.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.people.update", [$person->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.person.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $person->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.person.fields.gender') }}</label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Person::GENDER_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('gender', $person->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gender'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.gender_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="dob">{{ trans('cruds.person.fields.dob') }}</label>
                            <input class="form-control date" type="text" name="dob" id="dob" value="{{ old('dob', $person->dob) }}">
                            @if($errors->has('dob'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('dob') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.dob_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="age">{{ trans('cruds.person.fields.age') }}</label>
                            <input class="form-control" type="number" name="age" id="age" value="{{ old('age', $person->age) }}" step="1">
                            @if($errors->has('age'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('age') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.age_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="mobile">{{ trans('cruds.person.fields.mobile') }}</label>
                            <input class="form-control" type="text" name="mobile" id="mobile" value="{{ old('mobile', $person->mobile) }}">
                            @if($errors->has('mobile'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mobile') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.mobile_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="id_type_id">{{ trans('cruds.person.fields.id_type') }}</label>
                            <select class="form-control select2" name="id_type_id" id="id_type_id">
                                @foreach($id_types as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('id_type_id') ? old('id_type_id') : $person->id_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('id_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('id_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.id_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="id_detail">{{ trans('cruds.person.fields.id_detail') }}</label>
                            <input class="form-control" type="text" name="id_detail" id="id_detail" value="{{ old('id_detail', $person->id_detail) }}">
                            @if($errors->has('id_detail'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('id_detail') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.id_detail_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="recommended_by_detail">{{ trans('cruds.person.fields.recommended_by_detail') }}</label>
                            <input class="form-control" type="text" name="recommended_by_detail" id="recommended_by_detail" value="{{ old('recommended_by_detail', $person->recommended_by_detail) }}">
                            @if($errors->has('recommended_by_detail'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('recommended_by_detail') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.recommended_by_detail_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">{{ trans('cruds.person.fields.address') }}</label>
                            <textarea class="form-control" name="address" id="address">{{ old('address', $person->address) }}</textarea>
                            @if($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="country">{{ trans('cruds.person.fields.country') }}</label>
                            <input class="form-control" type="text" name="country" id="country" value="{{ old('country', $person->country) }}">
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.country_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="state">{{ trans('cruds.person.fields.state') }}</label>
                            <input class="form-control" type="text" name="state" id="state" value="{{ old('state', $person->state) }}">
                            @if($errors->has('state'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.state_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="district">{{ trans('cruds.person.fields.district') }}</label>
                            <input class="form-control" type="text" name="district" id="district" value="{{ old('district', $person->district) }}">
                            @if($errors->has('district'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('district') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.district_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="post_office">{{ trans('cruds.person.fields.post_office') }}</label>
                            <input class="form-control" type="text" name="post_office" id="post_office" value="{{ old('post_office', $person->post_office) }}">
                            @if($errors->has('post_office'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('post_office') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.post_office_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="pincode">{{ trans('cruds.person.fields.pincode') }}</label>
                            <input class="form-control" type="text" name="pincode" id="pincode" value="{{ old('pincode', $person->pincode) }}">
                            @if($errors->has('pincode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('pincode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.person.fields.pincode_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="photo">{{ trans('cruds.person.fields.photo') }}</label>
                            <div class="needsclick dropzone" id="photo-dropzone">
                            </div>
                            @if($errors->has('photo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('photo') }}
                                </div>
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

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('frontend.people.storeMedia') }}',
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