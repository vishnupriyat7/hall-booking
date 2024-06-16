@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.selfRegistration.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.self-registrations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.id') }}
                        </th>
                        <td>
                            {{ $selfRegistration->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.name') }}
                        </th>
                        <td>
                            {{ $selfRegistration->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\SelfRegistration::GENDER_SELECT[$selfRegistration->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date of Birth
                        </th>
                        <td>
                            {{ $selfRegistration->dob }}
                        </td>
                    </tr>
                    <!-- <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.age') }}
                        </th>
                        <td>
                            {{ $selfRegistration->age }}
                        </td>
                    </tr> -->
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.mobile') }}
                        </th>
                        <td>
                            {{ $selfRegistration->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.id_type') }}
                        </th>
                        <td>
                            {{ $selfRegistration->id_type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.id_detail') }}
                        </th>
                        <td>
                            {{ $selfRegistration->id_detail }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.address') }}
                        </th>
                        <td>
                            {{ $selfRegistration->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.country') }}
                        </th>
                        <td>
                            {{ App\Models\SelfRegistration::COUNTRY_SELECT[$selfRegistration->country] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.state') }}
                        </th>
                        <td>
                            {{ $selfRegistration->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.district') }}
                        </th>
                        <td>
                            {{ $selfRegistration->district }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfRegistration.fields.pincode') }}
                        </th>
                        <td>
                            {{ $selfRegistration->pincode }}
                        </td>
                    </tr>

                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.self-registrations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>



@endsection
