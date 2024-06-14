<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPersonRequest;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\IdType;
use App\Models\Person;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('person_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::with(['id_type', 'media'])->get();

        return view('frontend.people.index', compact('people'));
    }

    public function create()
    {
        abort_if(Gate::denies('person_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.people.create', compact('id_types'));
    }

    public function store(StorePersonRequest $request)
    {
        $person = Person::create($request->all());

        if ($request->input('photo', false)) {
            $person->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $person->id]);
        }

        return redirect()->route('frontend.people.index');
    }

    public function edit(Person $person)
    {
        abort_if(Gate::denies('person_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person->load('id_type');

        return view('frontend.people.edit', compact('id_types', 'person'));
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        $person->update($request->all());

        if ($request->input('photo', false)) {
            if (! $person->photo || $request->input('photo') !== $person->photo->file_name) {
                if ($person->photo) {
                    $person->photo->delete();
                }
                $person->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($person->photo) {
            $person->photo->delete();
        }

        return redirect()->route('frontend.people.index');
    }

    public function show(Person $person)
    {
        abort_if(Gate::denies('person_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->load('id_type');

        return view('frontend.people.show', compact('person'));
    }

    public function destroy(Person $person)
    {
        abort_if(Gate::denies('person_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->delete();

        return back();
    }

    public function massDestroy(MassDestroyPersonRequest $request)
    {
        $people = Person::find(request('ids'));

        foreach ($people as $person) {
            $person->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('person_create') && Gate::denies('person_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Person();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
