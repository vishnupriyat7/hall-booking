<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDistrictRequest;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Models\District;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('district_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $districts = District::with(['state_cd'])->get();

        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        abort_if(Gate::denies('district_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state_cds = State::pluck('state_cd', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.districts.create', compact('state_cds'));
    }

    public function store(StoreDistrictRequest $request)
    {
        $district = District::create($request->all());

        return redirect()->route('admin.districts.index');
    }

    public function edit(District $district)
    {
        abort_if(Gate::denies('district_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state_cds = State::pluck('state_cd', 'id')->prepend(trans('global.pleaseSelect'), '');

        $district->load('state_cd');

        return view('admin.districts.edit', compact('district', 'state_cds'));
    }

    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->all());

        return redirect()->route('admin.districts.index');
    }

    public function show(District $district)
    {
        abort_if(Gate::denies('district_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $district->load('state_cd');

        return view('admin.districts.show', compact('district'));
    }

    public function destroy(District $district)
    {
        abort_if(Gate::denies('district_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $district->delete();

        return back();
    }

    public function massDestroy(MassDestroyDistrictRequest $request)
    {
        $districts = District::find(request('ids'));

        foreach ($districts as $district) {
            $district->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
