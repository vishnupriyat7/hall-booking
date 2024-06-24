@extends('layouts.admin')
@section('content')
@can('post_office_detail_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.post-office-details.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.postOfficeDetail.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'PostOfficeDetail', 'route' => 'admin.post-office-details.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.postOfficeDetail.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-PostOfficeDetail">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.pincode') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.default_post_flag') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.post_office_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.post_office_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.state') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.district') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.district_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.postOfficeDetail.fields.postal_circle') }}
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
@can('post_office_detail_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.post-office-details.massDestroy') }}",
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
    ajax: "{{ route('admin.post-office-details.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'pincode', name: 'pincode' },
{ data: 'default_post_flag', name: 'default_post_flag' },
{ data: 'post_office_name', name: 'post_office_name' },
{ data: 'post_office_status', name: 'post_office_status' },
{ data: 'state_state_abbr', name: 'state.state_abbr' },
{ data: 'district_district_abbr', name: 'district.district_abbr' },
{ data: 'district_name', name: 'district_name' },
{ data: 'postal_circle', name: 'postal_circle' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-PostOfficeDetail').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection