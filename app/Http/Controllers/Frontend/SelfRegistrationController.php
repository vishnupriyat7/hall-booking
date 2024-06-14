<?php

namespace App\Http\Controllers\Frontend;

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

class SelfRegistrationController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('self_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistrations = SelfRegistration::with(['id_type', 'visiting_office_category', 'visiting_office', 'media'])->get();

        return view('frontend.selfRegistrations.index', compact('selfRegistrations'));
    }

    public function create()
    {
        abort_if(Gate::denies('self_registration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('frontend.selfRegistrations.create', compact('id_types', 'visiting_office_categories', 'visiting_offices'));
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

        return redirect()->route('frontend.self-registrations.index');
    }

    public function edit(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $selfRegistration->load('id_type', 'visiting_office_category', 'visiting_office');

        return view('frontend.selfRegistrations.edit', compact('id_types', 'selfRegistration', 'visiting_office_categories', 'visiting_offices'));
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

        return redirect()->route('frontend.self-registrations.index');
    }

    public function show(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistration->load('id_type', 'visiting_office_category', 'visiting_office');

        return view('frontend.selfRegistrations.show', compact('selfRegistration'));
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
