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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PostOfficeDetail">
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
                            {{ trans('cruds.postOfficeDetail.fields.epost_delivery_status') }}
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
                <tbody>
                    @foreach($postOfficeDetails as $key => $postOfficeDetail)
                        <tr data-entry-id="{{ $postOfficeDetail->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $postOfficeDetail->id ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->pincode ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->epost_delivery_status ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->default_post_flag ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->post_office_name ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->post_office_status ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->state->state_cd ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->district->district_abbr ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->district_name ?? '' }}
                            </td>
                            <td>
                                {{ $postOfficeDetail->postal_circle ?? '' }}
                            </td>
                            <td>
                                @can('post_office_detail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.post-office-details.show', $postOfficeDetail->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('post_office_detail_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.post-office-details.edit', $postOfficeDetail->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('post_office_detail_delete')
                                    <form action="{{ route('admin.post-office-details.destroy', $postOfficeDetail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('post_office_detail_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.post-office-details.massDestroy') }}",
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
  let table = $('.datatable-PostOfficeDetail:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection