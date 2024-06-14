@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.idType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.id-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.idType.fields.id') }}
                        </th>
                        <td>
                            {{ $idType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.idType.fields.name') }}
                        </th>
                        <td>
                            {{ $idType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.idType.fields.min_length') }}
                        </th>
                        <td>
                            {{ $idType->min_length }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.idType.fields.max_length') }}
                        </th>
                        <td>
                            {{ $idType->max_length }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.idType.fields.regex') }}
                        </th>
                        <td>
                            {{ $idType->regex }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.idType.fields.name_mal') }}
                        </th>
                        <td>
                            {{ $idType->name_mal }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.id-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection