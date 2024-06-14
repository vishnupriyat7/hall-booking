@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.selfRegistration.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.self-registrations.index') }}">
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
                                        {{ trans('cruds.selfRegistration.fields.age') }}
                                    </th>
                                    <td>
                                        {{ $selfRegistration->age }}
                                    </td>
                                </tr>
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
                                        {{ trans('cruds.selfRegistration.fields.pincode') }}
                                    </th>
                                    <td>
                                        {{ $selfRegistration->pincode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.photo') }}
                                    </th>
                                    <td>
                                        @if($selfRegistration->photo)
                                            <a href="{{ $selfRegistration->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $selfRegistration->photo->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.purpose') }}
                                    </th>
                                    <td>
                                        {{ App\Models\SelfRegistration::PURPOSE_SELECT[$selfRegistration->purpose] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.date_of_visit') }}
                                    </th>
                                    <td>
                                        {{ $selfRegistration->date_of_visit }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.visiting_office_category') }}
                                    </th>
                                    <td>
                                        {{ $selfRegistration->visiting_office_category->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.visiting_office') }}
                                    </th>
                                    <td>
                                        {{ $selfRegistration->visiting_office->name ?? '' }}
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
                                        {{ trans('cruds.selfRegistration.fields.post_office') }}
                                    </th>
                                    <td>
                                        {{ $selfRegistration->post_office }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.self-registrations.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection