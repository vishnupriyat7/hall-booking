<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdType;
use App\Models\Member;
use App\Models\VisitorPass;
use App\Models\RecommendingOfficeCategory;
use App\Models\VisitingOfficeCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
class VisitorPassControllerCustom extends Controller
{
    public function register()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $id_types = IdType::pluck('name', 'id')->prepend('RECOMMENDED BY', '-1')
            ->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $recommending_office_categories = RecommendingOfficeCategory::all()->pluck('title', 'id')->prepend( trans('global.pleaseSelect'), '');
        $mlas = Member::where('status', 'mla')->get();
        $ministers = Member::where('status', 'minister')->get();
        $date_of_visit = date('d.m.Y');

        return view('admin.visitorPasses.register', compact('id_types', 'visiting_office_categories', 'recommending_office_categories', 'mlas', 'ministers'));
    }
    public function print(Request $request)
    {

        \Log::info($request->all());
        $passid = $request->id;
        $visitorPass = VisitorPass::with(['person', 'person.id_type:id,name'])
        ->findOrFail($passid);
        \Log::info($visitorPass);
        $issued_date = Carbon::createFromFormat('Y-m-d H:i:s', $visitorPass->created_at, 'UTC')->setTimezone('Asia/Kolkata');
        $issued_on =  $issued_date->format('d.m.Y');
        $issued_at =  $issued_date->format('H:i a');

        return view('admin.visitorPasses.print', compact('visitorPass', 'issued_at', 'issued_on'));
    }
}
