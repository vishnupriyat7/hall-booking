@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.person.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.people.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.id') }}
                        </th>
                        <td>
                            {{ $person->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.name') }}
                        </th>
                        <td>
                            {{ $person->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Person::GENDER_SELECT[$person->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.dob') }}
                        </th>
                        <td>
                            {{ $person->dob }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.age') }}
                        </th>
                        <td>
                            {{ $person->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.mobile') }}
                        </th>
                        <td>
                            {{ $person->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.email') }}
                        </th>
                        <td>
                            {{ $person->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.id_type') }}
                        </th>
                        <td>
                            {{ $person->id_type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.id_detail') }}
                        </th>
                        <td>
                            {{ $person->id_detail }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.address') }}
                        </th>
                        <td>
                            {{ $person->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.country') }}
                        </th>
                        <td>
                            {{ $person->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.state') }}
                        </th>
                        <td>
                            {{ $person->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.district') }}
                        </th>
                        <td>
                            {{ $person->district }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.post_office') }}
                        </th>
                        <td>
                            {{ $person->post_office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.pincode') }}
                        </th>
                        <td>
                            {{ $person->pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.photo') }}
                        </th>
                        <td>
                            @if($person->photo)
                                <a href="{{ $person->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $person->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.people.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#person_visitor_passes" role="tab" data-toggle="tab">
                {{ trans('cruds.visitorPass.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="person_visitor_passes">
            @includeIf('admin.people.relationships.personVisitorPasses', ['visitorPasses' => $person->personVisitorPasses])
        </div>
    </div>
</div>

@endsection