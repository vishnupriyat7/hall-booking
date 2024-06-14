<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\IdType;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\VisitingOffice;
use App\Models\SelfRegistration;
use App\Http\Controllers\Controller;
use App\Models\VisitingOfficeCategory;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreSelfRegistrationRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateSelfRegistrationRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\MassDestroySelfRegistrationRequest;
use App\Models\VisitorPass;

class SelfRegistrationController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('self_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SelfRegistration::with(['id_type', 'visiting_office_category'])->select(sprintf('%s.*', (new SelfRegistration)->table));
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

            $table->editColumn('district', function ($row) {
                return $row->district ? $row->district : '';
            });
            $table->editColumn('post_office', function ($row) {
                return $row->post_office ? $row->post_office : '';
            });
            $table->editColumn('visiting_office', function ($row) {
                return $row->visiting_office ? $row->visiting_office : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'id_type', 'photo', 'visiting_office_category']);

            return $table->make(true);
        }

        return view('admin.selfRegistrations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('self_registration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.selfRegistrations.create', compact('id_types', 'visiting_office_categories'));
    }

    public function store(StoreSelfRegistrationRequest $request)
    {
        //$selfRegistration = SelfRegistration::create($request->all());

        //create person
        $person = new Person();
        $person->name = $request->name;
        $person->gender = $request->gender;
        $person->age = $request->age;
        $person->mobile = $request->mobile;
        $person->id_type_id = $request->id_type_id == -1 || $request->id_type_id == '' ? null : $request->id_type_id;
        $person->id_detail = $request->id_detail;
        $person->address = $request->address;
        $person->country = $request->country;
        $person->state = $request->state;
        $person->pincode = $request->pincode;
        $person->district = $request->district;
        $person->post_office = $request->post_office;
        $person->save();


        if ($request->input('photo', false)) {
            $person->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $person->id]);
        }

        //now create a pass
        $visitorPass = new VisitorPass();
        $visitorPass->person_id = $person->id;
        $visitorPass->purpose = $request->purpose;
        $visitorPass->visiting_office_category_id = $request->visiting_office_category_id;
        $visitorPass->visiting_office = $request->visiting_office || $request->visiting_office_name;
        $visitorPass->save();

       /* 'pass_valid_from',
        'pass_valid_upto',
        'issued_date',
        'number',
        'date_of_visit',*/

        return redirect()->route('admin.self-registrations.index');
    }

    public function edit(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $selfRegistration->load('id_type', 'visiting_office_category');

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

        $selfRegistration->load('id_type', 'visiting_office_category');

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
