<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class PersonController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('person_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Person::with(['id_type'])->select(sprintf('%s.*', (new Person)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'person_show';
                $editGate      = 'person_edit';
                $deleteGate    = 'person_delete';
                $crudRoutePart = 'people';

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
                return $row->gender ? Person::GENDER_SELECT[$row->gender] : '';
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
            $table->editColumn('recommended_by_detail', function ($row) {
                return $row->recommended_by_detail ? $row->recommended_by_detail : '';
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
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                       // $photo->thumbnail
                        $photo->url
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'id_type', 'photo']);

            return $table->make(true);
        }

        return view('admin.people.index');
    }

    public function create()
    {
        abort_if(Gate::denies('person_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.people.create', compact('id_types'));
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

        return redirect()->route('admin.people.index');
    }

    public function edit(Person $person)
    {
        abort_if(Gate::denies('person_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person->load('id_type');

        return view('admin.people.edit', compact('id_types', 'person'));
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

        return redirect()->route('admin.people.index');
    }

    public function show(Person $person)
    {
        abort_if(Gate::denies('person_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->load('id_type');

        return view('admin.people.show', compact('person'));
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
