<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitorPassRequest;
use App\Http\Requests\UpdateVisitorPassRequest;
use App\Models\Person;
use App\Models\VisitorPass;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VisitorPassController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('visitor_pass_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VisitorPass::with(['person'])->select(sprintf('%s.*', (new VisitorPass)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'visitor_pass_show';
                $editGate      = 'visitor_pass_edit';
                $deleteGate    = 'visitor_pass_delete';
                $crudRoutePart = 'visitor-passes';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('person_name', function ($row) {
                return $row->person ? $row->person->name : '';
            });

            $table->editColumn('person.mobile', function ($row) {
                return $row->person ? (is_string($row->person) ? $row->person : $row->person->mobile) : '';
            });
            $table->editColumn('person.id_detail', function ($row) {
                return $row->person ? (is_string($row->person) ? $row->person : $row->person->id_detail) : '';
            });

            $table->editColumn('number', function ($row) {
                return $row->number ? $row->number : '';
            });

            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? VisitorPass::PURPOSE_SELECT[$row->purpose] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'person']);

            return $table->make(true);
        }

        return view('admin.visitorPasses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.visitorPasses.create', compact('people'));
    }

    public function store(StoreVisitorPassRequest $request)
    {
        $visitorPass = VisitorPass::create($request->all());

        return redirect()->route('admin.visitor-passes.index');
    }

    public function edit(VisitorPass $visitorPass)
    {
        abort_if(Gate::denies('visitor_pass_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visitorPass->load('person');

        return view('admin.visitorPasses.edit', compact('people', 'visitorPass'));
    }

    public function update(UpdateVisitorPassRequest $request, VisitorPass $visitorPass)
    {
        $visitorPass->update($request->all());

        return redirect()->route('admin.visitor-passes.index');
    }

    public function show(VisitorPass $visitorPass)
    {
        abort_if(Gate::denies('visitor_pass_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitorPass->load('person');

        return view('admin.visitorPasses.show', compact('visitorPass'));
    }
}
