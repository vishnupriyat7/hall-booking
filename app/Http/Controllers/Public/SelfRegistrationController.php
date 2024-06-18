<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySelfRegistrationRequest;
use App\Http\Requests\StoreSelfRegistrationRequest;
use App\Http\Requests\UpdateSelfRegistrationRequest;
use App\Models\Person;
use App\Models\IdType;
use App\Models\SelfRegistration;
use App\Models\VisitingOffice;
use App\Models\VisitingOfficeCategory;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class SelfRegistrationController extends Controller
{
    // use MediaUploadingTrait;



    public function create()
    {

        $id_types = IdType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visiting_office_categories = VisitingOfficeCategory::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('public.selfRegistrations.create', compact('id_types', 'visiting_office_categories'));
    }

    public function store(Request $request)
    {
        // 'name',
        // 'gender',
        // 'age',
        // 'mobile',
        // 'id_type_id',
        // 'id_detail',
        // 'address',
        // 'country',
        // 'state',
        // 'pincode',



        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'mobile' => 'required|min:10|max:10',
            'id_type_id' => 'required',
            'id_detail' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'district' => 'required',
            'pincode' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        }

        $person = Person::where('mobile', $request->mobile)
            ->when($request->id_type_id != -1, function($query) use ($request) {
                return $query->orwhere('id_detail', $request->id_detail);
            })
            ->first();

        if($person) {
           // return response()->json( [ 'errors' => ['personid' => 'Person already exists with same mobile number or id number'] ], 401 );
        }

        //check if the user is already registered with same mobile number
        //or same card type and number
        $selfRegistration = SelfRegistration::where('mobile', $request->mobile)
            ->orWhere(function ($query) use ($request) {
                $query->where('id_type_id', $request->id_type_id)
                    ->where('id_detail', $request->id_detail);
            })->first();

        $alreadyRegistered = false;
        if ($selfRegistration) {
            $alreadyRegistered = true;
            return view('public.selfRegistrations.show', compact('selfRegistration', 'alreadyRegistered', 'person') );
        }



        \DB::transaction(function () use ($request, &$selfRegistration) {
            \Log::info($request->all());
            $age = Carbon::createFromFormat('Y-m-d', $request->dob)->age;
            $lastNumberOfToday = SelfRegistration::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
            $lastNumber = $lastNumberOfToday ? $lastNumberOfToday->number : 0;
            $number = $lastNumber + 1;

            $selfRegistration = SelfRegistration::create(
                $request->all()
                + ['age' => $age, 'pass_type' => 'visitor', 'number' => $number]);
        });

        return view('public.selfRegistrations.show', compact('selfRegistration', 'alreadyRegistered', 'person') );

    }


    // public function update(UpdateSelfRegistrationRequest $request, SelfRegistration $selfRegistration)
    // {
    //     $selfRegistration->update($request->all());

    //     if ($request->input('photo', false)) {
    //         if (! $selfRegistration->photo || $request->input('photo') !== $selfRegistration->photo->file_name) {
    //             if ($selfRegistration->photo) {
    //                 $selfRegistration->photo->delete();
    //             }
    //             $selfRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
    //         }
    //     } elseif ($selfRegistration->photo) {
    //         $selfRegistration->photo->delete();
    //     }

    //     return redirect()->route('public.self-registrations.index');
    // }

    public function show(SelfRegistration $selfRegistration)
    {
       // abort_if(Gate::denies('self_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistration->load('id_type', 'visiting_office_category');

        return view('public.selfRegistrations.show', compact('selfRegistration'));
    }

    // public function destroy(SelfRegistration $selfRegistration)
    // {
    //    // abort_if(Gate::denies('self_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $selfRegistration->delete();

    //     return back();
    // }


    // public function storeCKEditorImages(Request $request)
    // {
    //    // abort_if(Gate::denies('self_registration_create') && Gate::denies('self_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $model         = new SelfRegistration();
    //     $model->id     = $request->input('crud_id', 0);
    //     $model->exists = true;
    //     $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

    //     return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    // }
}
