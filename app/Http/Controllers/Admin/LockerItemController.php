<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLockerItemRequest;
use App\Http\Requests\StoreLockerItemRequest;
use App\Http\Requests\UpdateLockerItemRequest;
use App\Models\Locker;
use App\Models\LockerItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockerItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('locker_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockerItems = LockerItem::with(['locker'])->get();

        return view('admin.lockerItems.index', compact('lockerItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('locker_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockers = Locker::pluck('token', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.lockerItems.create', compact('lockers'));
    }

    public function store(StoreLockerItemRequest $request)
    {
        $lockerItem = LockerItem::create($request->all());

        return redirect()->route('admin.locker-items.index');
    }

    public function edit(LockerItem $lockerItem)
    {
        abort_if(Gate::denies('locker_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockers = Locker::pluck('token', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lockerItem->load('locker');

        return view('admin.lockerItems.edit', compact('lockerItem', 'lockers'));
    }

    public function update(UpdateLockerItemRequest $request, LockerItem $lockerItem)
    {
        $lockerItem->update($request->all());

        return redirect()->route('admin.locker-items.index');
    }

    public function show(LockerItem $lockerItem)
    {
        abort_if(Gate::denies('locker_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockerItem->load('locker');

        return view('admin.lockerItems.show', compact('lockerItem'));
    }

    public function destroy(LockerItem $lockerItem)
    {
        abort_if(Gate::denies('locker_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockerItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyLockerItemRequest $request)
    {
        $lockerItems = LockerItem::find(request('ids'));

        foreach ($lockerItems as $lockerItem) {
            $lockerItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
