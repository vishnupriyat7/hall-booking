@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.groupPerson.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.group-people.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.groupPerson.fields.id') }}
                        </th>
                        <td>
                            {{ $groupPerson->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.groupPerson.fields.name') }}
                        </th>
                        <td>
                            {{ $groupPerson->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.groupPerson.fields.age') }}
                        </th>
                        <td>
                            {{ $groupPerson->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.groupPerson.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\GroupPerson::GENDER_SELECT[$groupPerson->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.groupPerson.fields.gallery_pass') }}
                        </th>
                        <td>
                            {{ $groupPerson->gallery_pass->number ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.group-people.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection