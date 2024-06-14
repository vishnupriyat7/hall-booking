@extends('layouts.admin')
@section('content')
@can('self_registration_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.self-registrations.create') }}">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SelfRegistration">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('self_registration_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.self-registrations.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.self-registrations.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'gender', name: 'gender' },
{ data: 'age', name: 'age' },
{ data: 'mobile', name: 'mobile' },
{ data: 'id_type_name', name: 'id_type.name' },
{ data: 'id_detail', name: 'id_detail' },
{ data: 'address', name: 'address' },
{ data: 'country', name: 'country' },
{ data: 'state', name: 'state' },
{ data: 'pincode', name: 'pincode' },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'purpose', name: 'purpose' },
{ data: 'date_of_visit', name: 'date_of_visit' },
{ data: 'visiting_office_category_title', name: 'visiting_office_category.title' },
{ data: 'visiting_office_name', name: 'visiting_office.name' },
{ data: 'district', name: 'district' },
{ data: 'post_office', name: 'post_office' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-SelfRegistration').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
