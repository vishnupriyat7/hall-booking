@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.session.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sessions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.session.fields.id') }}
                        </th>
                        <td>
                            {{ $session->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.session.fields.name') }}
                        </th>
                        <td>
                            {{ $session->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.session.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $session->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sessions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection