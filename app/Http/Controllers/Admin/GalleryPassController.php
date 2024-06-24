<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryPassRequest;
use App\Http\Requests\UpdateGalleryPassRequest;
use App\Models\GalleryPass;
use App\Models\GuidingOfficer;
use App\Models\Person;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GalleryPassController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('visitor_pass_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = GalleryPass::with(['person', 'guide'])->select(sprintf('%s.*', (new GalleryPass)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'visitor_pass_show';
                $editGate      = 'visitor_pass_edit';
                $deleteGate    = 'visitor_pass_delete';
                $crudRoutePart = 'gallery-passes';

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
                return $row->number ? $row->number : '';
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

            $table->addColumn('guide_name', function ($row) {
                return $row->guide ? $row->guide->name : '';
            });

            $table->editColumn('print_count', function ($row) {
                return $row->print_count ? $row->print_count : '';
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
            $table->editColumn('photo', function ($row) {
                return $row->photo ? $row->photo : '';
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
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'person', 'guide']);

            return $table->make(true);
        }

        return view('admin.galleryPasses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $guides = GuidingOfficer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.galleryPasses.create', compact('guides', 'people'));
    }

    public function store(StoreGalleryPassRequest $request)
    {
        $galleryPass = GalleryPass::create($request->all());

        return redirect()->route('admin.gallery-passes.index');
    }

    public function edit(GalleryPass $galleryPass)
    {
        abort_if(Gate::denies('visitor_pass_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $guides = GuidingOfficer::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $galleryPass->load('person', 'guide');

        return view('admin.galleryPasses.edit', compact('galleryPass', 'guides', 'people'));
    }

    public function update(UpdateGalleryPassRequest $request, GalleryPass $galleryPass)
    {
        $galleryPass->update($request->all());

        return redirect()->route('admin.gallery-passes.index');
    }

    public function show(GalleryPass $galleryPass)
    {
        abort_if(Gate::denies('visitor_pass_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $galleryPass->load('person', 'guide');

        return view('admin.galleryPasses.show', compact('galleryPass'));
    }
}
