<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRecommendingOfficeRequest;
use App\Http\Requests\StoreRecommendingOfficeRequest;
use App\Http\Requests\UpdateRecommendingOfficeRequest;
use App\Models\RecommendingOffice;
use App\Models\RecommendingOfficeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecommendingOfficeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recommending_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recommendingOffices = RecommendingOffice::with(['category'])->get();

        return view('admin.recommendingOffices.index', compact('recommendingOffices'));
    }

    public function create()
    {
        abort_if(Gate::denies('recommending_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = RecommendingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.recommendingOffices.create', compact('categories'));
    }

    public function store(StoreRecommendingOfficeRequest $request)
    {
        $recommendingOffice = RecommendingOffice::create($request->all());

        return redirect()->route('admin.recommending-offices.index');
    }

    public function edit(RecommendingOffice $recommendingOffice)
    {
        abort_if(Gate::denies('recommending_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = RecommendingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $recommendingOffice->load('category');

        return view('admin.recommendingOffices.edit', compact('categories', 'recommendingOffice'));
    }

    public function update(UpdateRecommendingOfficeRequest $request, RecommendingOffice $recommendingOffice)
    {
        $recommendingOffice->update($request->all());

        return redirect()->route('admin.recommending-offices.index');
    }

    public function show(RecommendingOffice $recommendingOffice)
    {
        abort_if(Gate::denies('recommending_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recommendingOffice->load('category');

        return view('admin.recommendingOffices.show', compact('recommendingOffice'));
    }

    public function destroy(RecommendingOffice $recommendingOffice)
    {
        abort_if(Gate::denies('recommending_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recommendingOffice->delete();

        return back();
    }

    public function massDestroy(MassDestroyRecommendingOfficeRequest $request)
    {
        $recommendingOffices = RecommendingOffice::find(request('ids'));

        foreach ($recommendingOffices as $recommendingOffice) {
            $recommendingOffice->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
