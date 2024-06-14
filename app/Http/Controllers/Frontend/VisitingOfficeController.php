<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVisitingOfficeRequest;
use App\Http\Requests\StoreVisitingOfficeRequest;
use App\Http\Requests\UpdateVisitingOfficeRequest;
use App\Models\VisitingOffice;
use App\Models\VisitingOfficeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitingOfficeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('visiting_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitingOffices = VisitingOffice::with(['category'])->get();

        return view('frontend.visitingOffices.index', compact('visitingOffices'));
    }

    public function create()
    {
        abort_if(Gate::denies('visiting_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.visitingOffices.create', compact('categories'));
    }

    public function store(StoreVisitingOfficeRequest $request)
    {
        $visitingOffice = VisitingOffice::create($request->all());

        return redirect()->route('frontend.visiting-offices.index');
    }

    public function edit(VisitingOffice $visitingOffice)
    {
        abort_if(Gate::denies('visiting_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visitingOffice->load('category');

        return view('frontend.visitingOffices.edit', compact('categories', 'visitingOffice'));
    }

    public function update(UpdateVisitingOfficeRequest $request, VisitingOffice $visitingOffice)
    {
        $visitingOffice->update($request->all());

        return redirect()->route('frontend.visiting-offices.index');
    }

    public function show(VisitingOffice $visitingOffice)
    {
        abort_if(Gate::denies('visiting_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitingOffice->load('category');

        return view('frontend.visitingOffices.show', compact('visitingOffice'));
    }

    public function destroy(VisitingOffice $visitingOffice)
    {
        abort_if(Gate::denies('visiting_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitingOffice->delete();

        return back();
    }

    public function massDestroy(MassDestroyVisitingOfficeRequest $request)
    {
        $visitingOffices = VisitingOffice::find(request('ids'));

        foreach ($visitingOffices as $visitingOffice) {
            $visitingOffice->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
