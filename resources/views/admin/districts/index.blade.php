@extends('layouts.admin')
@section('content')
@can('district_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.districts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.district.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'District', 'route' => 'admin.districts.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.district.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-District">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.district.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.district.fields.state_cd') }}
                        </th>
                        <th>
                            {{ trans('cruds.district.fields.district_abbr') }}
                        </th>
                        <th>
                            {{ trans('cruds.district.fields.district_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.district.fields.pin_code') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($districts as $key => $district)
                        <tr data-entry-id="{{ $district->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $district->id ?? '' }}
                            </td>
                            <td>
                                {{ $district->state_cd->state_cd ?? '' }}
                            </td>
                            <td>
                                {{ $district->district_abbr ?? '' }}
                            </td>
                            <td>
                                {{ $district->district_name ?? '' }}
                            </td>
                            <td>
                                {{ $district->pin_code ?? '' }}
                            </td>
                            <td>
                                @can('district_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.districts.show', $district->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('district_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.districts.edit', $district->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('district_delete')
                                    <form action="{{ route('admin.districts.destroy', $district->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('district_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.districts.massDestroy') }}",
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
  let table = $('.datatable-District:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection