@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.galleryPass.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gallery-passes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.id') }}
                        </th>
                        <td>
                            {{ $galleryPass->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.number') }}
                        </th>
                        <td>
                            {{ $galleryPass->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.person') }}
                        </th>
                        <td>
                            {{ $galleryPass->person->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.issued_date') }}
                        </th>
                        <td>
                            {{ $galleryPass->issued_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.date_of_visit') }}
                        </th>
                        <td>
                            {{ $galleryPass->date_of_visit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.guide') }}
                        </th>
                        <td>
                            {{ $galleryPass->guide->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.print_count') }}
                        </th>
                        <td>
                            {{ $galleryPass->print_count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.id_type') }}
                        </th>
                        <td>
                            {{ $galleryPass->id_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.id_detail') }}
                        </th>
                        <td>
                            {{ $galleryPass->id_detail }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.address') }}
                        </th>
                        <td>
                            {{ $galleryPass->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.country') }}
                        </th>
                        <td>
                            {{ $galleryPass->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.state') }}
                        </th>
                        <td>
                            {{ $galleryPass->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.district') }}
                        </th>
                        <td>
                            {{ $galleryPass->district }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.post_office') }}
                        </th>
                        <td>
                            {{ $galleryPass->post_office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.pincode') }}
                        </th>
                        <td>
                            {{ $galleryPass->pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.photo') }}
                        </th>
                        <td>
                            {{ $galleryPass->photo }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gallery-passes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection