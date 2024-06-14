@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('self_registration_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.self-registrations.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.selfRegistration.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.selfRegistration.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-SelfRegistration">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.gender') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.age') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.mobile') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.id_type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.id_detail') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.address') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.country') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.state') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.pincode') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.photo') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.purpose') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.date_of_visit') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.visiting_office_category') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.visiting_office') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.district') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.selfRegistration.fields.post_office') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selfRegistrations as $key => $selfRegistration)
                                    <tr data-entry-id="{{ $selfRegistration->id }}">
                                        <td>
                                            {{ $selfRegistration->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\SelfRegistration::GENDER_SELECT[$selfRegistration->gender] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->age ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->mobile ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->id_type->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->id_detail ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->address ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\SelfRegistration::COUNTRY_SELECT[$selfRegistration->country] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->state ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->pincode ?? '' }}
                                        </td>
                                        <td>
                                            @if($selfRegistration->photo)
                                                <a href="{{ $selfRegistration->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $selfRegistration->photo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ App\Models\SelfRegistration::PURPOSE_SELECT[$selfRegistration->purpose] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->date_of_visit ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->visiting_office_category->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->visiting_office->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->district ?? '' }}
                                        </td>
                                        <td>
                                            {{ $selfRegistration->post_office ?? '' }}
                                        </td>
                                        <td>
                                            @can('self_registration_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.self-registrations.show', $selfRegistration->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('self_registration_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.self-registrations.edit', $selfRegistration->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('self_registration_delete')
                                                <form action="{{ route('frontend.self-registrations.destroy', $selfRegistration->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('self_registration_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.self-registrations.massDestroy') }}",
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
  let table = $('.datatable-SelfRegistration:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection