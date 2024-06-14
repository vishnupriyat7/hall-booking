<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIdTypeRequest;
use App\Http\Requests\StoreIdTypeRequest;
use App\Http\Requests\UpdateIdTypeRequest;
use App\Models\IdType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdTypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('id_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $idTypes = IdType::all();

        return view('frontend.idTypes.index', compact('idTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('id_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.idTypes.create');
    }

    public function store(StoreIdTypeRequest $request)
    {
        $idType = IdType::create($request->all());

        return redirect()->route('frontend.id-types.index');
    }

    public function edit(IdType $idType)
    {
        abort_if(Gate::denies('id_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.idTypes.edit', compact('idType'));
    }

    public function update(UpdateIdTypeRequest $request, IdType $idType)
    {
        $idType->update($request->all());

        return redirect()->route('frontend.id-types.index');
    }

    public function destroy(IdType $idType)
    {
        abort_if(Gate::denies('id_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $idType->delete();

        return back();
    }

    public function massDestroy(MassDestroyIdTypeRequest $request)
    {
        $idTypes = IdType::find(request('ids'));

        foreach ($idTypes as $idType) {
            $idType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
