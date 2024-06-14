@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('person_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.people.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.person.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.person.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Person">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.person.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.gender') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.dob') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.age') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.mobile') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.id_type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.id_detail') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.recommended_by_detail') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.address') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.country') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.state') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.post_office') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.pincode') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.person.fields.photo') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($people as $key => $person)
                                    <tr data-entry-id="{{ $person->id }}">
                                        <td>
                                            {{ $person->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Person::GENDER_SELECT[$person->gender] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->dob ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->age ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->mobile ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->id_type->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->id_detail ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->recommended_by_detail ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->address ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->country ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->state ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->post_office ?? '' }}
                                        </td>
                                        <td>
                                            {{ $person->pincode ?? '' }}
                                        </td>
                                        <td>
                                            @if($person->photo)
                                                <a href="{{ $person->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $person->photo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @can('person_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.people.show', $person->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('person_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.people.edit', $person->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('person_delete')
                                                <form action="{{ route('frontend.people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('person_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.people.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Person:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection