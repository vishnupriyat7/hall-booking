<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyVisitingOfficeCategoryRequest;
use App\Http\Requests\StoreVisitingOfficeCategoryRequest;
use App\Http\Requests\UpdateVisitingOfficeCategoryRequest;
use App\Models\VisitingOfficeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitingOfficeCategoryController extends Controller
{
    use CsvImportTrait;
    public function index()
    {
        abort_if(Gate::denies('visiting_office_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitingOfficeCategories = VisitingOfficeCategory::all();

        return view('admin.visitingOfficeCategories.index', compact('visitingOfficeCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('visiting_office_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visitingOfficeCategories.create');
    }

    public function store(StoreVisitingOfficeCategoryRequest $request)
    {
        $visitingOfficeCategory = VisitingOfficeCategory::create($request->all());

        return redirect()->route('admin.visiting-office-categories.index');
    }

    public function edit(VisitingOfficeCategory $visitingOfficeCategory)
    {
        abort_if(Gate::denies('visiting_office_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visitingOfficeCategories.edit', compact('visitingOfficeCategory'));
    }

    public function update(UpdateVisitingOfficeCategoryRequest $request, VisitingOfficeCategory $visitingOfficeCategory)
    {
        $visitingOfficeCategory->update($request->all());

        return redirect()->route('admin.visiting-office-categories.index');
    }

    public function show(VisitingOfficeCategory $visitingOfficeCategory)
    {
        abort_if(Gate::denies('visiting_office_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visitingOfficeCategories.show', compact('visitingOfficeCategory'));
    }

    public function destroy(VisitingOfficeCategory $visitingOfficeCategory)
    {
        abort_if(Gate::denies('visiting_office_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitingOfficeCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyVisitingOfficeCategoryRequest $request)
    {
        $visitingOfficeCategories = VisitingOfficeCategory::find(request('ids'));

        foreach ($visitingOfficeCategories as $visitingOfficeCategory) {
            $visitingOfficeCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
