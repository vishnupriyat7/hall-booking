<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitorPassRequest;
use App\Http\Requests\UpdateVisitorPassRequest;
use App\Models\Person;
use App\Models\RecommendingOfficeCategory;
use App\Models\VisitingOfficeCategory;
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
            $query = VisitorPass::with(['person', 'person.id_type' ,'visiting_office_category', 'recommending_office_category'])->select(sprintf('%s.*', (new VisitorPass)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'visitor_pass_show';
                $editGate      = 'visitor_pass_edit';
                $deleteGate    = 'visitor_pass_delete';
                $crudRoutePart = 'visitor-passes';

                return view('partials.visitorPassActions', compact(
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
            $table->editColumn('number', function ($row) {
                return $row->number ? /*$row->created_at->format('Y-m-d/') .*/$row->number : '';
            });
            $table->addColumn('person_name', function ($row) {
                return $row->person ? $row->person->name : '';
            });

            $table->editColumn('person.mobile', function ($row) {
                return $row->person ? (is_string($row->person) ? $row->person : $row->person->mobile) : '';
            });
            $table->editColumn('person.id_detail', function ($row) {
                return $row->person ? (is_string($row->person) ? $row->person : $row->person->id_type?->name .' ' . $row->person->id_detail) : '';
            });

            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? VisitorPass::PURPOSE_SELECT[$row->purpose] : '';
            });
            $table->editColumn('visiting_office', function ($row) {
                return $row->visiting_office ? $row->visiting_office : '';
            });
            $table->editColumn('recommending_office', function ($row) {
                return $row->recommending_office ? $row->recommending_office : '';
            });
            $table->addColumn('visiting_office_category_title', function ($row) {
                return $row->visiting_office_category ? $row->visiting_office_category->title : '';
            });

            $table->addColumn('recommending_office_category_title', function ($row) {
                return $row->recommending_office_category ? $row->recommending_office_category->title : '';
            });

            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : '';
            });
            $table->editColumn('id_type', function ($row) {
                return $row->id_type ? $row->id_type : '';
            });
            $table->editColumn('id_detail', function ($row) {
                return $row->id_detail ? $row->id_detail : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : '';
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : '';
            });
            $table->editColumn('district', function ($row) {
                return $row->district ? $row->district : '';
            });
            $table->editColumn('post_office', function ($row) {
                return $row->post_office ? $row->post_office : '';
            });
            $table->editColumn('pincode', function ($row) {
                return $row->pincode ? $row->pincode : '';
            });
            $table->editColumn('print_count', function ($row) {
                return $row->print_count ? $row->print_count : '';
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? $row->photo : '';
            });
            $table->editColumn('camera_allowed', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->camera_allowed ? 'checked' : null) . '>';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? $row->gender : '';
            });

            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'person', 'visiting_office_category', 'recommending_office_category', 'camera_allowed']);

            return $table->make(true);
        }

        return view('admin.visitorPasses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $recommending_office_categories = RecommendingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.visitorPasses.create', compact('people', 'recommending_office_categories', 'visiting_office_categories'));
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

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $recommending_office_categories = RecommendingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visitorPass->load('person', 'visiting_office_category', 'recommending_office_category');

        return view('admin.visitorPasses.edit', compact('people', 'recommending_office_categories', 'visiting_office_categories', 'visitorPass'));
    }

    public function update(UpdateVisitorPassRequest $request, VisitorPass $visitorPass)
    {
        $visitorPass->update($request->all());

        return redirect()->route('admin.visitor-passes.index');
    }

    public function show(VisitorPass $visitorPass)
    {
        abort_if(Gate::denies('visitor_pass_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitorPass->load('person', 'visiting_office_category', 'recommending_office_category');

        return view('admin.visitorPasses.show', compact('visitorPass'));
    }
}
