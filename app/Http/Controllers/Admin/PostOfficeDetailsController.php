<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPostOfficeDetailRequest;
use App\Http\Requests\StorePostOfficeDetailRequest;
use App\Http\Requests\UpdatePostOfficeDetailRequest;
use App\Models\District;
use App\Models\PostOfficeDetail;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostOfficeDetailsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('post_office_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postOfficeDetails = PostOfficeDetail::with(['state', 'district'])->get();

        return view('admin.postOfficeDetails.index', compact('postOfficeDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('post_office_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $states = State::pluck('state_cd', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::pluck('district_abbr', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.postOfficeDetails.create', compact('districts', 'states'));
    }

    public function store(StorePostOfficeDetailRequest $request)
    {
        $postOfficeDetail = PostOfficeDetail::create($request->all());

        return redirect()->route('admin.post-office-details.index');
    }

    public function edit(PostOfficeDetail $postOfficeDetail)
    {
        abort_if(Gate::denies('post_office_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $states = State::pluck('state_cd', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::pluck('district_abbr', 'id')->prepend(trans('global.pleaseSelect'), '');

        $postOfficeDetail->load('state', 'district');

        return view('admin.postOfficeDetails.edit', compact('districts', 'postOfficeDetail', 'states'));
    }

    public function update(UpdatePostOfficeDetailRequest $request, PostOfficeDetail $postOfficeDetail)
    {
        $postOfficeDetail->update($request->all());

        return redirect()->route('admin.post-office-details.index');
    }

    public function show(PostOfficeDetail $postOfficeDetail)
    {
        abort_if(Gate::denies('post_office_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postOfficeDetail->load('state', 'district');

        return view('admin.postOfficeDetails.show', compact('postOfficeDetail'));
    }

    public function destroy(PostOfficeDetail $postOfficeDetail)
    {
        abort_if(Gate::denies('post_office_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postOfficeDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostOfficeDetailRequest $request)
    {
        $postOfficeDetails = PostOfficeDetail::find(request('ids'));

        foreach ($postOfficeDetails as $postOfficeDetail) {
            $postOfficeDetail->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
