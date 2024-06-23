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
use Yajra\DataTables\Facades\DataTables;

class PostOfficeDetailsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('post_office_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PostOfficeDetail::with(['state', 'district'])->select(sprintf('%s.*', (new PostOfficeDetail)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'post_office_detail_show';
                $editGate      = 'post_office_detail_edit';
                $deleteGate    = 'post_office_detail_delete';
                $crudRoutePart = 'post-office-details';

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
            $table->editColumn('pincode', function ($row) {
                return $row->pincode ? $row->pincode : '';
            });
            $table->editColumn('default_post_flag', function ($row) {
                return $row->default_post_flag ? $row->default_post_flag : '';
            });
            $table->editColumn('post_office_name', function ($row) {
                return $row->post_office_name ? $row->post_office_name : '';
            });
            $table->editColumn('post_office_status', function ($row) {
                return $row->post_office_status ? $row->post_office_status : '';
            });
            $table->addColumn('state_state_abbr', function ($row) {
                return $row->state ? $row->state->state_abbr : '';
            });

            $table->addColumn('district_district_abbr', function ($row) {
                return $row->district ? $row->district->district_abbr : '';
            });

            $table->editColumn('district_name', function ($row) {
                return $row->district_name ? $row->district_name : '';
            });
            $table->editColumn('postal_circle', function ($row) {
                return $row->postal_circle ? $row->postal_circle : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'state', 'district']);

            return $table->make(true);
        }

        return view('admin.postOfficeDetails.index');
    }

    public function create()
    {
        abort_if(Gate::denies('post_office_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $states = State::pluck('state_abbr', 'id')->prepend(trans('global.pleaseSelect'), '');

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

        $states = State::pluck('state_abbr', 'id')->prepend(trans('global.pleaseSelect'), '');

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
