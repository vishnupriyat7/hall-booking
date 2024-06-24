@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.postOfficeDetail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.post-office-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.pincode') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.default_post_flag') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->default_post_flag }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.post_office_name') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->post_office_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.post_office_status') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->post_office_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.state') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->state->state_abbr ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.district') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->district->district_abbr ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.district_name') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->district_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postOfficeDetail.fields.postal_circle') }}
                        </th>
                        <td>
                            {{ $postOfficeDetail->postal_circle }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.post-office-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection