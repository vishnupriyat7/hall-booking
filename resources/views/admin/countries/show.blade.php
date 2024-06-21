@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.country.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.countries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.id') }}
                        </th>
                        <td>
                            {{ $country->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.country_abbr') }}
                        </th>
                        <td>
                            {{ $country->country_abbr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.country_name') }}
                        </th>
                        <td>
                            {{ $country->country_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.is_default_country') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $country->is_default_country ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.iso_3') }}
                        </th>
                        <td>
                            {{ $country->iso_3 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.numcode') }}
                        </th>
                        <td>
                            {{ $country->numcode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.default_country') }}
                        </th>
                        <td>
                            {{ $country->default_country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.iso') }}
                        </th>
                        <td>
                            {{ $country->iso }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.countries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection