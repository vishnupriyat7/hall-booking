@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.guidingOfficer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.guiding-officers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.guidingOfficer.fields.id') }}
                        </th>
                        <td>
                            {{ $guidingOfficer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.guidingOfficer.fields.name') }}
                        </th>
                        <td>
                            {{ $guidingOfficer->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.guidingOfficer.fields.pen') }}
                        </th>
                        <td>
                            {{ $guidingOfficer->pen }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.guiding-officers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection