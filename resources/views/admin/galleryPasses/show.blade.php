@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Search Gallery Pass
    </div>

    <div class="card-body">
        <div class="form-group">
            <form class="form-inline">
                <div class="form-group">
                    <label for="id">Gallery Pass Id</label>
                    <input type="number" id="id" name="id" class="form-control" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">View</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
   // add an event listener to the form
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        // get the value of the input field with id="id"
        const id = document.getElementById('id').value;
        // redirect to the route with the id value
        window.location.href = '/admin/gallery-passes/' + id;
    });

</script>



<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.galleryPass.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">

        @if($galleryPass->photo)
                                <a href="{{ $galleryPass->photo }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $galleryPass->photo }}">
                                </a>
                            @endif

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.id') }}
                        </th>
                        <td>
                            {{ $galleryPass->id }}
                        </td>
                        <th>
                        </th>
                        <td>
                        </td>

                    </tr>
                    <tr>
                        <th>
                           Token {{ trans('cruds.galleryPass.fields.number') }}
                        </th>
                        <td>
                            {{ $galleryPass->number }}
                        </td>

                        <th>
                            {{ trans('cruds.galleryPass.fields.issued_date') }}
                        </th>
                        <td>
                            {{ $galleryPass->issued_date }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.name') }}
                        </th>
                        <td>
                            {{ $galleryPass->name }}
                        </td>

                        <th>
                            {{ trans('cruds.galleryPass.fields.gender') }}
                        </th>
                        <td>
                            {{ $galleryPass->gender }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.dob') }}
                        </th>
                        <td>
                            {{ $galleryPass->dob }}
                        </td>

                        <th>
                            {{ trans('cruds.galleryPass.fields.age') }}
                        </th>
                        <td>
                            {{ $galleryPass->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.mobile') }}
                        </th>
                        <td>
                            {{ $galleryPass->mobile }}
                        </td>

                        <th>
                            {{ trans('cruds.galleryPass.fields.email') }}
                        </th>
                        <td>
                            {{ $galleryPass->email }}
                        </td>
                    </tr>


                    <tr>
                        <th>
                            {{ trans('cruds.galleryPass.fields.guide') }}
                        </th>
                        <td>
                            {{ $galleryPass->guide->name ?? '' }}
                        </td>

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

                        <th>
                            {{ trans('cruds.galleryPass.fields.pincode') }}
                        </th>
                        <td>
                            {{ $galleryPass->pincode }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            No of Accompanying Persons
                        </th>
                        <td>
                            {{ $galleryPass->num_persons }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <h5>Accompanying Persons</h5>

            <!-- display all accompanying persons -->

                    <div class="">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Sl No
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Gender
                                </th>
                                <th>
                                    Age
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($galleryPass->accompanyingPersons as $companion)
                            <tr>

                            <td>
                                {{ $companion->sl_no }}
                            </td>
                            <td>
                                {{ $companion->name }}
                            </td>
                            <td>
                                {{ $companion->gender }}
                            </td>

                            <td>
                                {{ $companion->age }}
                            </td>


                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gallery-passes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

        </div>
    </div>
</div>



@endsection
