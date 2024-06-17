<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyIdTypeRequest;
use App\Http\Requests\StoreIdTypeRequest;
use App\Http\Requests\UpdateIdTypeRequest;
use App\Models\IdType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdTypesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('id_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $idTypes = IdType::all();

        return view('admin.idTypes.index', compact('idTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('id_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.idTypes.create');
    }

    public function store(StoreIdTypeRequest $request)
    {
        $idType = IdType::create($request->all());

        return redirect()->route('admin.id-types.index');
    }

    public function edit(IdType $idType)
    {
        abort_if(Gate::denies('id_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.idTypes.edit', compact('idType'));
    }

    public function update(UpdateIdTypeRequest $request, IdType $idType)
    {
        $idType->update($request->all());

        return redirect()->route('admin.id-types.index');
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
