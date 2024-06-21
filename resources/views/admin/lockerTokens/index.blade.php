@extends('layouts.admin')
@section('content')
@can('locker_token_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.locker-tokens.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.lockerToken.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.lockerToken.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LockerToken">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.lockerToken.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.lockerToken.fields.token') }}
                        </th>
                        <th>
                            {{ trans('cruds.lockerToken.fields.enabled') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lockerTokens as $key => $lockerToken)
                        <tr data-entry-id="{{ $lockerToken->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $lockerToken->id ?? '' }}
                            </td>
                            <td>
                                {{ $lockerToken->token ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $lockerToken->enabled ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $lockerToken->enabled ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('locker_token_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.locker-tokens.show', $lockerToken->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('locker_token_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.locker-tokens.edit', $lockerToken->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('locker_token_delete')
                                    <form action="{{ route('admin.locker-tokens.destroy', $lockerToken->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('locker_token_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.locker-tokens.massDestroy') }}",
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
  let table = $('.datatable-LockerToken:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection