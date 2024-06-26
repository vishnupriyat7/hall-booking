<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\IdType;
use App\Models\Member;
use App\Models\Person;
use App\Models\Country;
use App\Models\VisitorPass;
use Illuminate\Http\Request;
use App\Models\PostOfficeDetail;
use App\Http\Controllers\Controller;
use App\Models\VisitingOfficeCategory;
use Illuminate\Support\Facades\Storage;
use App\Models\RecommendingOfficeCategory;
use Symfony\Component\HttpFoundation\Response;

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
        $countries  = Country::all()->pluck('country_name', 'id')->prepend( trans('global.pleaseSelect'), '');
        return view('admin.visitorPasses.register', compact( 'countries', 'id_types', 'visiting_office_categories', 'recommending_office_categories', 'mlas', 'ministers'));
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

    public function store(Request $request)
    {

        $personid = $request->personid;
        $person = null;
        if($personid && $personid != -1) {
            $person = Person::find($personid);
            if(!$person) {
                return response()->json( [ 'errors' => ['personid' => 'Person not found'] ], 404);
            }
            //test
          //  return response()->json( [ 'errors' => ['personid' => 'Person found'] ], 401 );
          //update person


        } else {

            $person = Person:://where('mobile', $request->mobile)->
            when($request->id_type_id != -1, function($query) use ($request) {
                return $query->where('id_type_id', $request->id_type_id)->where('id_detail', $request->id_detail);
            })
            ->first();

            if($person) {
               // return response()->json( [ 'errors' => ['personid' => 'Person already exists with same id number'] ], 401 );
            }
        }

        //make sure if id type is recommended by, recommender is also provided
        $recommendingOfficeCat = null;
        $recommendingOffice = null;
        if($request->id_type_id == -1) {

            if(!$request->recommending_office_category_id) {
                return response()->json( [ 'errors' => ['recommending_office_category' => 'Recommending office category is required for this id type'] ], 401 );
            }
            $recommendingOfficeCat = RecommendingOfficeCategory::find($request->recommending_office_category_id);

            if( $recommendingOfficeCat->title == 'MLA' ) {
                if(!$request->recommending_office_mla || 'Select' == $request->recommending_office_mla) {
                    return response()->json( [ 'errors' => ['recommending_office' => 'Recommending office is required'] ], 401 );
                }
                $recommendingOffice = $request->recommending_office_mla . ' (MLA)';
            } else if( $recommendingOfficeCat->title == 'Minister' ) {
                if(!$request->recommending_office_minister || 'Select' == $request->recommending_office_minister) {
                    return response()->json( [ 'errors' => ['recommending_office' => 'Recommending office is required'] ], 401 );
                }
                $recommendingOffice =  'Minister: ' . $request->recommending_office_minister;
            }
            else{
               if(!$request->recommending_office_input) {
                    return response()->json( [ 'errors' => ['recommending_office' => 'Recommending office is required for this id type'] ], 401 );
                }
                $recommendingOffice = $request->recommending_office_input;
            }
        }

        $postOffice =  $request->post_office ??  $request->post_office_select;
        if(!$postOffice ) {
            return response()->json( [ 'errors' => ['post_office' => 'postOffice is required'] ], 401 );
        }

        if(!$request->visiting_office_category_id ) {
            return response()->json( [ 'errors' => ['visiting_office' => 'Visiting office Category is required'] ], 401 );
        }
        $visitingOfficeCat = VisitingOfficeCategory::find($request->visiting_office_category_id);
        $visitingOffice = null;
        if( $visitingOfficeCat->title == 'MLA'  ) {
            if(!$request->visiting_office_mla || 'Select' == $request->visiting_office_mla) {
                return response()->json( [ 'errors' => ['visiting_office' => 'Visiting office is required'] ], 401 );
            }
            $visitingOffice = $request->visiting_office_mla;
        } else if( $visitingOfficeCat->title == 'Minister' ) {
            if(!$request->visiting_office_minister || 'Select' == $request->visiting_office_minister) {
                return response()->json( [ 'errors' => ['visiting_office' => 'Visiting office is required'] ], 401 );
            }
            $visitingOffice = $request->visiting_office_minister;
        }
        else {
            if(!$request->visiting_office_input) {
                return response()->json( [ 'errors' => ['visiting_office' => 'Visiting office is required'] ], 401 );
            }
            $visitingOffice = $request->visiting_office_input;
        }



        //create person
        if(!$person) {
            $person = new Person();
        }
        $dob = Carbon::createFromFormat( 'd.m.Y', $request->dob)->format( 'Y-m-d' );


        $person->name = $request->name;
        $person->gender = $request->gender;
        $person->age = $request->age;
        $person->dob = $dob;
        $person->mobile = $request->mobile;
        $person->id_type_id = $request->id_type_id == -1 || $request->id_type_id == '' ? null : $request->id_type_id;
        $person->id_detail = $request->id_detail;
        $person->address = $request->address;
        $person->country = $request->country;
        $person->state = $request->state;
        $person->pincode = $request->pincode;
        $person->district = $request->district;
        $person->post_office = $postOffice;
        $person->save();


        if ($request->input('photo', false)) {

           /////////photo///////////
           //$person->addMediaFromRequest('photo')->toMediaCollection('photo');


            $img = $request->photo;
            $folderPath = "photos_tmp/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
        //  $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName =  $person->id .  '_' . Carbon::today()->format('Y-m-d') . '.png';
            $file = $folderPath . $fileName;

            ////////////


            if(!Storage::disk('public')->put($file, $image_base64)) {
                return response()->json( [ 'errors' => ['photo' => 'Error saving photo'] ], 401 );
            }

            $person->addMedia(storage_path('app/public/photos_tmp/' . $fileName))->toMediaCollection('photo');
         //   $person->addMedia(storage_path('app/photos/' . $fileName))->toMediaCollection('photo');

        }

        // if ($media = $request->input('ck-media', false)) {
        //     Media::whereIn('id', $media)->update(['model_id' => $person->id]);
        // }

        //now create a pass

        //use transaction here to make sure number is unique


        $visitorPass = null;
        \DB::transaction( function() use ($request, $person, $visitingOffice, $recommendingOffice, &$visitorPass, $dob, $postOffice)
        {
            if($request->passid) {
                $visitorPass = VisitorPass::find($request->passid);

                if(!$visitorPass) {
                    return response()->json( [ 'errors' => ['pass_id' => 'Pass not found'] ], 404);
                }
            }
            else {
                $visitorPass = new VisitorPass();
                // $lastNumberOfThisYear = VisitorPass::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'desc')->first();
                //find last number of today
                $lastNumberOfToday = VisitorPass::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
                $lastNumber = $lastNumberOfToday ? $lastNumberOfToday->number : 0;
                $visitorPass->number = $lastNumber + 1;
            }
            $idtype = $request->id_type_id != -1 ? IdType::find($request->id_type_id)->name : null;


           // $visitorPass = new VisitorPass();
            $visitorPass->person_id = $person->id;

            $visitorPass->dob =  $dob;
            $visitorPass->age = $request->age;
            $visitorPass->mobile = $request->mobile;
            $visitorPass->id_type =  $idtype;
            $visitorPass->id_detail = $request->id_detail;
            $visitorPass->address = $request->address;
            $visitorPass->country = $request->country;
            $visitorPass->state = $request->state;
            $visitorPass->pincode = $request->pincode;
            $visitorPass->district = $request->district;
            $visitorPass->post_office = $postOffice;
            $visitorPass->photo = $person->getMedia('photo')->last()?->getUrl() ?? null;

            $visitorPass->purpose = $request->purpose;
            $visitorPass->visiting_office_category_id = $request->visiting_office_category_id;
            $visitorPass->visiting_office = $visitingOffice;
            $visitorPass->recommending_office_category_id = $request->recommending_office_category_id;
            $visitorPass->recommending_office = $recommendingOffice;
            $visitorPass->pass_valid_from = Carbon::now()->format('Y-m-d H:i:s');
            //$visitorPass->pass_valid_upto = $request->pass_valid_upto;
            $visitorPass->issued_date = Carbon::now()->format('Y-m-d');

            $visitorPass->date_of_visit = Carbon::createFromFormat( 'd.m.Y', $request->date_of_visit)->format( 'Y-m-d' );

            $visitorPass->save();
           // return response()->json( [ 'success' => 'Pass created successfully', 'pass'=> $visitorPass ] );
        });


        return response()->json( [ 'success' => 'Pass created successfully', 'pass'=>$visitorPass ] );
    }

    public function fetchPinDetails(Request $request)
    {
        //$pincode = $request->pincode;
        $pincode = $request->route('pincode');
        $pincodeDetails = PostOfficeDetail::with(['state','district'])->where('pincode', $pincode)->get();

        if($pincodeDetails->count() > 0) {

            return response()->json( [ 'success' => 'Pincode details fetched successfully',
            'pincodeDetails' => $pincodeDetails ]);
        } else {
            return response()->json( [ 'errors' => ['pincode' => 'Pincode not found'] ], 404);
        }

    }


}
