<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitorPassRequest;
use App\Http\Requests\UpdateVisitorPassRequest;
use App\Models\Person;
use App\Models\VisitorPass;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorPassController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('visitor_pass_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitorPasses = VisitorPass::with(['person'])->get();

        return view('frontend.visitorPasses.index', compact('visitorPasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.visitorPasses.create', compact('people'));
    }

    public function store(StoreVisitorPassRequest $request)
    {
        $visitorPass = VisitorPass::create($request->all());

        return redirect()->route('frontend.visitor-passes.index');
    }

    public function edit(VisitorPass $visitorPass)
    {
        abort_if(Gate::denies('visitor_pass_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visitorPass->load('person');

        return view('frontend.visitorPasses.edit', compact('people', 'visitorPass'));
    }

    public function update(UpdateVisitorPassRequest $request, VisitorPass $visitorPass)
    {
        $visitorPass->update($request->all());

        return redirect()->route('frontend.visitor-passes.index');
    }

    public function show(VisitorPass $visitorPass)
    {
        abort_if(Gate::denies('visitor_pass_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitorPass->load('person');

        return view('frontend.visitorPasses.show', compact('visitorPass'));
    }
}
