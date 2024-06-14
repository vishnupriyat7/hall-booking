@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.visitorPass.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.visitor-passes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.id') }}
                        </th>
                        <td>
                            {{ $visitorPass->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.number') }}
                        </th>
                        <td>
                            {{ $visitorPass->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.person') }}
                        </th>
                        <td>
                            {{ $visitorPass->person->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.pass_valid_from') }}
                        </th>
                        <td>
                            {{ $visitorPass->pass_valid_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.pass_valid_upto') }}
                        </th>
                        <td>
                            {{ $visitorPass->pass_valid_upto }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.issued_date') }}
                        </th>
                        <td>
                            {{ $visitorPass->issued_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.date_of_visit') }}
                        </th>
                        <td>
                            {{ $visitorPass->date_of_visit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.purpose') }}
                        </th>
                        <td>
                            {{ App\Models\VisitorPass::PURPOSE_SELECT[$visitorPass->purpose] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.visiting_office_category') }}
                        </th>
                        <td>
                            {{ $visitorPass->visiting_office_category->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.visiting_office') }}
                        </th>
                        <td>
                            {{ $visitorPass->visiting_office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.recommending_office_category') }}
                        </th>
                        <td>
                            {{ $visitorPass->recommending_office_category->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorPass.fields.recommending_office') }}
                        </th>
                        <td>
                            {{ $visitorPass->recommending_office }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.visitor-passes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection