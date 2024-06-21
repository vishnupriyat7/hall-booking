@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.lockerItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.locker-items.update", [$lockerItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="item_name">{{ trans('cruds.lockerItem.fields.item_name') }}</label>
                <input class="form-control {{ $errors->has('item_name') ? 'is-invalid' : '' }}" type="text" name="item_name" id="item_name" value="{{ old('item_name', $lockerItem->item_name) }}">
                @if($errors->has('item_name'))
                    <span class="text-danger">{{ $errors->first('item_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.lockerItem.fields.item_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="item_count">{{ trans('cruds.lockerItem.fields.item_count') }}</label>
                <input class="form-control {{ $errors->has('item_count') ? 'is-invalid' : '' }}" type="number" name="item_count" id="item_count" value="{{ old('item_count', $lockerItem->item_count) }}" step="1">
                @if($errors->has('item_count'))
                    <span class="text-danger">{{ $errors->first('item_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.lockerItem.fields.item_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="locker_id">{{ trans('cruds.lockerItem.fields.locker') }}</label>
                <select class="form-control select2 {{ $errors->has('locker') ? 'is-invalid' : '' }}" name="locker_id" id="locker_id" required>
                    @foreach($lockers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('locker_id') ? old('locker_id') : $lockerItem->locker->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('locker'))
                    <span class="text-danger">{{ $errors->first('locker') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.lockerItem.fields.locker_helper') }}</span>
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