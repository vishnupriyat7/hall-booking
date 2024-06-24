@can($viewGate)
<a class="btn btn-xs btn-dark" href="{{ route('admin.' . $crudRoutePart . '.print', $row->id) }}" target="_blank">
        Print
    </a>
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan

