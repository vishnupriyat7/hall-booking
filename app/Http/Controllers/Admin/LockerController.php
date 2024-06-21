<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLockerRequest;
use App\Http\Requests\StoreLockerRequest;
use App\Http\Requests\UpdateLockerRequest;
use App\Models\GalleryPass;
use App\Models\Locker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('locker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockers = Locker::with(['pass'])->get();

        return view('admin.lockers.index', compact('lockers'));
    }

    public function create()
    {
        abort_if(Gate::denies('locker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $passes = GalleryPass::pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.lockers.create', compact('passes'));
    }

    public function store(StoreLockerRequest $request)
    {
        $locker = Locker::create($request->all());

        return redirect()->route('admin.lockers.index');
    }

    public function edit(Locker $locker)
    {
        abort_if(Gate::denies('locker_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $passes = GalleryPass::pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locker->load('pass');

        return view('admin.lockers.edit', compact('locker', 'passes'));
    }

    public function update(UpdateLockerRequest $request, Locker $locker)
    {
        $locker->update($request->all());

        return redirect()->route('admin.lockers.index');
    }

    public function show(Locker $locker)
    {
        abort_if(Gate::denies('locker_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locker->load('pass');

        return view('admin.lockers.show', compact('locker'));
    }

    public function destroy(Locker $locker)
    {
        abort_if(Gate::denies('locker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locker->delete();

        return back();
    }

    public function massDestroy(MassDestroyLockerRequest $request)
    {
        $lockers = Locker::find(request('ids'));

        foreach ($lockers as $locker) {
            $locker->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
