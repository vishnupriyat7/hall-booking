@extends('layouts.admin')
@section('content')
@can('visitor_pass_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.visitor-passes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.visitorPass.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.visitorPass.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-VisitorPass">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.person') }}
                    </th>
                    <th>
                        {{ trans('cruds.person.fields.mobile') }}
                    </th>
                    <th>
                        {{ trans('cruds.person.fields.id_detail') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.pass_valid_from') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.pass_valid_upto') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.issued_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.date_of_visit') }}
                    </th>
                    <th>
                        {{ trans('cruds.visitorPass.fields.purpose') }}
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
  
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.visitor-passes.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'number', name: 'number' },
{ data: 'person_name', name: 'person.name' },
{ data: 'person.mobile', name: 'person.mobile' },
{ data: 'person.id_detail', name: 'person.id_detail' },
{ data: 'pass_valid_from', name: 'pass_valid_from' },
{ data: 'pass_valid_upto', name: 'pass_valid_upto' },
{ data: 'issued_date', name: 'issued_date' },
{ data: 'date_of_visit', name: 'date_of_visit' },
{ data: 'purpose', name: 'purpose' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-VisitorPass').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection