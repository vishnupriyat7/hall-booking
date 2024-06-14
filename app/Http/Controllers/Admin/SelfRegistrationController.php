<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySelfRegistrationRequest;
use App\Http\Requests\StoreSelfRegistrationRequest;
use App\Http\Requests\UpdateSelfRegistrationRequest;
use App\Models\IdType;
use App\Models\SelfRegistration;
use App\Models\VisitingOffice;
use App\Models\VisitingOfficeCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SelfRegistrationController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('self_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SelfRegistration::with(['id_type', 'visiting_office_category', 'visiting_office'])->select(sprintf('%s.*', (new SelfRegistration)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'self_registration_show';
                $editGate      = 'self_registration_edit';
                $deleteGate    = 'self_registration_delete';
                $crudRoutePart = 'self-registrations';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? SelfRegistration::GENDER_SELECT[$row->gender] : '';
            });
            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : '';
            });
            $table->addColumn('id_type_name', function ($row) {
                return $row->id_type ? $row->id_type->name : '';
            });

            $table->editColumn('id_detail', function ($row) {
                return $row->id_detail ? $row->id_detail : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('country', function ($row) {
                return $row->country ? SelfRegistration::COUNTRY_SELECT[$row->country] : '';
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : '';
            });
            $table->editColumn('pincode', function ($row) {
                return $row->pincode ? $row->pincode : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? SelfRegistration::PURPOSE_SELECT[$row->purpose] : '';
            });

            $table->addColumn('visiting_office_category_title', function ($row) {
                return $row->visiting_office_category ? $row->visiting_office_category->title : '';
            });

            $table->addColumn('visiting_office_name', function ($row) {
                return $row->visiting_office ? $row->visiting_office->name : '';
            });

            $table->editColumn('district', function ($row) {
                return $row->district ? $row->district : '';
            });
            $table->editColumn('post_office', function ($row) {
                return $row->post_office ? $row->post_office : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'id_type', 'photo', 'visiting_office_category', 'visiting_office']);

            return $table->make(true);
        }

        return view('admin.selfRegistrations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('self_registration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_offices = VisitingOffice::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.selfRegistrations.create', compact('id_types', 'visiting_office_categories', 'visiting_offices'));
    }

    public function store(StoreSelfRegistrationRequest $request)
    {
        $selfRegistration = SelfRegistration::create($request->all());

        if ($request->input('photo', false)) {
            $selfRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $selfRegistration->id]);
        }

        return redirect()->route('admin.self-registrations.index');
    }

    public function edit(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_offices = VisitingOffice::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $selfRegistration->load('id_type', 'visiting_office_category', 'visiting_office');

        return view('admin.selfRegistrations.edit', compact('id_types', 'selfRegistration', 'visiting_office_categories', 'visiting_offices'));
    }

    public function update(UpdateSelfRegistrationRequest $request, SelfRegistration $selfRegistration)
    {
        $selfRegistration->update($request->all());

        if ($request->input('photo', false)) {
            if (! $selfRegistration->photo || $request->input('photo') !== $selfRegistration->photo->file_name) {
                if ($selfRegistration->photo) {
                    $selfRegistration->photo->delete();
                }
                $selfRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($selfRegistration->photo) {
            $selfRegistration->photo->delete();
        }

        return redirect()->route('admin.self-registrations.index');
    }

    public function show(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistration->load('id_type', 'visiting_office_category', 'visiting_office');

        return view('admin.selfRegistrations.show', compact('selfRegistration'));
    }

    public function destroy(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistration->delete();

        return back();
    }

    public function massDestroy(MassDestroySelfRegistrationRequest $request)
    {
        $selfRegistrations = SelfRegistration::find(request('ids'));

        foreach ($selfRegistrations as $selfRegistration) {
            $selfRegistration->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('self_registration_create') && Gate::denies('self_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SelfRegistration();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
