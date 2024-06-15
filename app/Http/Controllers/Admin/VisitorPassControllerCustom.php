<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdType;
use App\Models\Member;
use App\Models\Person;
use App\Models\RecommendingOfficeCategory;
use App\Models\VisitingOfficeCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class VisitorPassControllerCustom extends Controller
{
    public function register()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $id_types = IdType::pluck('name', 'id')->prepend('RECOMMENDED BY', '-1')
            ->prepend(trans('global.pleaseSelect'), '');

        // $visiting_office_categories = [
        //     'Legislature Secretary' => 'Legislature Secretary',
        //     'MLA' => 'MLA',
        //     'Minister' => 'Minister',
        //     'Speaker' => 'Speaker',
        //     'Deputy Speaker' => 'Deputy Speaker',
        //     'Chief Minister' => 'Chief Minister',
        //     'Leader of Opposition' => 'Leader of Opposition',
        //     'Legislative Assembly' => 'Legislative Assembly',
        //     'Secretariat' => 'Secretariat',
        //     'Other' => 'Other',
        // ];
        // $visiting_office_categories = collect($visiting_office_categories)->prepend(trans('global.pleaseSelect'), '');

        // $recommending_office_categories = [
        //     'Legislature Secretary' => 'Legislature Secretary',
        //     'MLA' => 'MLA',
        //     'Minister' => 'Minister',
        //     'Speaker' => 'Speaker',
        //     'Deputy Speaker' => 'Deputy Speaker',
        //     'Chief Minister' => 'Chief Minister',
        //     'Leader of Opposition' => 'Leader of Opposition',
        //     'Other' => 'Other',
        // ];
        // $recommending_office_categories = collect($recommending_office_categories)->prepend(trans('global.pleaseSelect'), '');
        $visiting_office_categories = VisitingOfficeCategory::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $recommending_office_categories = RecommendingOfficeCategory::all()->pluck('title', 'id')->prepend( trans('global.pleaseSelect'), '');
        $mlas = Member::where('status', 'mla')->get();
        $ministers = Member::where('status', 'minister')->get();
        $date_of_visit = date('d.m.Y');

        return view('admin.visitorPasses.register', compact('id_types', 'visiting_office_categories', 'recommending_office_categories', 'mlas', 'ministers'));
    }
}
