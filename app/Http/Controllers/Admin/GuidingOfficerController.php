<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGuidingOfficerRequest;
use App\Http\Requests\StoreGuidingOfficerRequest;
use App\Http\Requests\UpdateGuidingOfficerRequest;
use App\Models\GuidingOfficer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuidingOfficerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('guiding_officer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $guidingOfficers = GuidingOfficer::all();

        return view('admin.guidingOfficers.index', compact('guidingOfficers'));
    }

    public function create()
    {
        abort_if(Gate::denies('guiding_officer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.guidingOfficers.create');
    }

    public function store(StoreGuidingOfficerRequest $request)
    {
        $guidingOfficer = GuidingOfficer::create($request->all());

        return redirect()->route('admin.guiding-officers.index');
    }

    public function edit(GuidingOfficer $guidingOfficer)
    {
        abort_if(Gate::denies('guiding_officer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.guidingOfficers.edit', compact('guidingOfficer'));
    }

    public function update(UpdateGuidingOfficerRequest $request, GuidingOfficer $guidingOfficer)
    {
        $guidingOfficer->update($request->all());

        return redirect()->route('admin.guiding-officers.index');
    }

    public function show(GuidingOfficer $guidingOfficer)
    {
        abort_if(Gate::denies('guiding_officer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.guidingOfficers.show', compact('guidingOfficer'));
    }

    public function destroy(GuidingOfficer $guidingOfficer)
    {
        abort_if(Gate::denies('guiding_officer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $guidingOfficer->delete();

        return back();
    }

    public function massDestroy(MassDestroyGuidingOfficerRequest $request)
    {
        $guidingOfficers = GuidingOfficer::find(request('ids'));

        foreach ($guidingOfficers as $guidingOfficer) {
            $guidingOfficer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
