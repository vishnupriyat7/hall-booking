@extends('layouts.pub')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.selfRegistration.title') }}
    </div>
    <div class="card-body">
        <div class="form-group">


            <table class="table">
                <tbody>
                    <tr>
                        <th>
                            Registration Number
                        </th>
                        <td>
                            {{ $selfRegistration->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date of Registration
                        </th>
                        <td>
                            {{ $selfRegistration->created_at->format('d-m-Y') }}
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
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
