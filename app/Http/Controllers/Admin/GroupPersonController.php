<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGroupPersonRequest;
use App\Http\Requests\StoreGroupPersonRequest;
use App\Http\Requests\UpdateGroupPersonRequest;
use App\Models\GroupPerson;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupPersonController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('group_person_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groupPeople = GroupPerson::all();

        return view('admin.groupPeople.index', compact('groupPeople'));
    }

    public function create()
    {
        abort_if(Gate::denies('group_person_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.groupPeople.create');
    }

    public function store(StoreGroupPersonRequest $request)
    {
        $groupPerson = GroupPerson::create($request->all());

        return redirect()->route('admin.group-people.index');
    }

    public function edit(GroupPerson $groupPerson)
    {
        abort_if(Gate::denies('group_person_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.groupPeople.edit', compact('groupPerson'));
    }

    public function update(UpdateGroupPersonRequest $request, GroupPerson $groupPerson)
    {
        $groupPerson->update($request->all());

        return redirect()->route('admin.group-people.index');
    }

    public function show(GroupPerson $groupPerson)
    {
        abort_if(Gate::denies('group_person_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.groupPeople.show', compact('groupPerson'));
    }

    public function destroy(GroupPerson $groupPerson)
    {
        abort_if(Gate::denies('group_person_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groupPerson->delete();

        return back();
    }

    public function massDestroy(MassDestroyGroupPersonRequest $request)
    {
        $groupPeople = GroupPerson::find(request('ids'));

        foreach ($groupPeople as $groupPerson) {
            $groupPerson->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
