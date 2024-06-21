<div class="m-3">
    @can('gallery_pass_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.gallery-passes.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.galleryPass.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.galleryPass.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-personGalleryPasses">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.number') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.person') }}
                            </th>
                            <th>
                                {{ trans('cruds.person.fields.mobile') }}
                            </th>
                            <th>
                                {{ trans('cruds.person.fields.id_detail') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.issued_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.date_of_visit') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.guide') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.print_count') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.id_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.id_detail') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.address') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.country') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.state') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.district') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.post_office') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.pincode') }}
                            </th>
                            <th>
                                {{ trans('cruds.galleryPass.fields.photo') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($galleryPasses as $key => $galleryPass)
                            <tr data-entry-id="{{ $galleryPass->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $galleryPass->id ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->number ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->person->name ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->person->mobile ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->person->id_detail ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->issued_date ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->date_of_visit ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->guide->name ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->print_count ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->id_type ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->id_detail ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->address ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->country ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->state ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->district ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->post_office ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->pincode ?? '' }}
                                </td>
                                <td>
                                    {{ $galleryPass->photo ?? '' }}
                                </td>
                                <td>
                                    @can('gallery_pass_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.gallery-passes.show', $galleryPass->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('gallery_pass_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.gallery-passes.edit', $galleryPass->id) }}">
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
  let table = $('.datatable-personGalleryPasses:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection