<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLockerTokenRequest;
use App\Http\Requests\StoreLockerTokenRequest;
use App\Http\Requests\UpdateLockerTokenRequest;
use App\Models\LockerToken;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockerTokenController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('locker_token_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockerTokens = LockerToken::all();

        return view('admin.lockerTokens.index', compact('lockerTokens'));
    }

    public function create()
    {
        abort_if(Gate::denies('locker_token_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lockerTokens.create');
    }

    public function store(StoreLockerTokenRequest $request)
    {
        $lockerToken = LockerToken::create($request->all());

        return redirect()->route('admin.locker-tokens.index');
    }

    public function edit(LockerToken $lockerToken)
    {
        abort_if(Gate::denies('locker_token_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lockerTokens.edit', compact('lockerToken'));
    }

    public function update(UpdateLockerTokenRequest $request, LockerToken $lockerToken)
    {
        $lockerToken->update($request->all());

        return redirect()->route('admin.locker-tokens.index');
    }

    public function show(LockerToken $lockerToken)
    {
        abort_if(Gate::denies('locker_token_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lockerTokens.show', compact('lockerToken'));
    }

    public function destroy(LockerToken $lockerToken)
    {
        abort_if(Gate::denies('locker_token_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lockerToken->delete();

        return back();
    }

    public function massDestroy(MassDestroyLockerTokenRequest $request)
    {
        $lockerTokens = LockerToken::find(request('ids'));

        foreach ($lockerTokens as $lockerToken) {
            $lockerToken->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
