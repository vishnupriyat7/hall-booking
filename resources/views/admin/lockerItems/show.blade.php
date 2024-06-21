@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.lockerItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.locker-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.lockerItem.fields.id') }}
                        </th>
                        <td>
                            {{ $lockerItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lockerItem.fields.item_name') }}
                        </th>
                        <td>
                            {{ $lockerItem->item_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lockerItem.fields.item_count') }}
                        </th>
                        <td>
                            {{ $lockerItem->item_count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lockerItem.fields.locker') }}
                        </th>
                        <td>
                            {{ $lockerItem->locker->token ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.locker-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection