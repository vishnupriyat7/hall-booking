@extends('layouts.admin')
@section('content')
@can('person_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.people.create') }}">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Person">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('person_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.people.massDestroy') }}",
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
    ajax: "{{ route('admin.people.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'gender', name: 'gender' },
{ data: 'dob', name: 'dob' },
{ data: 'age', name: 'age' },
{ data: 'mobile', name: 'mobile' },
{ data: 'id_type_name', name: 'id_type.name' },
{ data: 'id_detail', name: 'id_detail' },
{ data: 'recommended_by_detail', name: 'recommended_by_detail' },
{ data: 'address', name: 'address' },
{ data: 'country', name: 'country' },
{ data: 'state', name: 'state' },
{ data: 'post_office', name: 'post_office' },
{ data: 'pincode', name: 'pincode' },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Person').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection