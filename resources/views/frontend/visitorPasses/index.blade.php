@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('visitor_pass_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.visitor-passes.create') }}">
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
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-VisitorPass">
                            <thead>
                                <tr>
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
                            <tbody>
                                @foreach($visitorPasses as $key => $visitorPass)
                                    <tr data-entry-id="{{ $visitorPass->id }}">
                                        <td>
                                            {{ $visitorPass->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->number ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->person->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->person->mobile ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->person->id_detail ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->pass_valid_from ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->pass_valid_upto ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->issued_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $visitorPass->date_of_visit ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\VisitorPass::PURPOSE_SELECT[$visitorPass->purpose] ?? '' }}
                                        </td>
                                        <td>
                                            @can('visitor_pass_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.visitor-passes.show', $visitorPass->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('visitor_pass_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.visitor-passes.edit', $visitorPass->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-VisitorPass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection