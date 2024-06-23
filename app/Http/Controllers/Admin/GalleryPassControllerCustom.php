<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\IdType;
use App\Models\Member;
use App\Models\Person;
use App\Models\GalleryPass;
use Illuminate\Http\Request;
use App\Models\GuidingOfficer;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\VisitingOfficeCategory;
use Illuminate\Support\Facades\Storage;
use App\Models\RecommendingOfficeCategory;
use Symfony\Component\HttpFoundation\Response;

class GalleryPassControllerCustom extends Controller
{
    public function register()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $id_types = IdType::pluck('name', 'id')->prepend('RECOMMENDED BY', '-1')
            ->prepend(trans('global.pleaseSelect'), '');


        $recommending_office_categories = RecommendingOfficeCategory::all()->pluck('title', 'id')->prepend( trans('global.pleaseSelect'), '');
        $mlas = Member::where('status', 'mla')->get();
        $ministers = Member::where('status', 'minister')->get();
      //  $date_of_visit = date('d.m.Y');

        $guides = GuidingOfficer::all();
        $countries  = Country::all()->pluck('country_name', 'id')->prepend( trans('global.pleaseSelect'), '');

        return view('admin.galleryPasses.register', compact('id_types', 'recommending_office_categories', 'mlas', 'ministers', 'guides','countries'));
    }
    public function print(Request $request)
    {

        \Log::info($request->all());
        $passid = $request->id;
        $galleryPass = GalleryPass::with(['person', 'person.id_type:id,name'])
        ->findOrFail($passid);
        \Log::info($galleryPass);
        $issued_date = Carbon::createFromFormat('Y-m-d H:i:s', $galleryPass->created_at, 'UTC')->setTimezone('Asia/Kolkata');
        $issued_on =  $issued_date->format('d.m.Y');
        $issued_at =  $issued_date->format('H:i a');

        return view('admin.galleryPasses.print', compact('galleryPass', 'issued_at', 'issued_on'));
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

            $person = Person::
            //where('mobile', $request->mobile)->
            when($request->id_type_id != -1, function($query) use ($request) {
                return $query->where('id_type_id', $request->id_type_id)->where('id_detail', $request->id_detail);
            })
            ->first();

            if($person) {
             //   return response()->json( [ 'errors' => ['personid' => 'Person already exists with same id number'] ], 401 );
            }
        }

        //make sure if id type is recommended by, recommender is also provided

        $recommendingOfficeCat = null;
        $recommendingOffice = null;
        /*
        if($request->id_type_id == -1) {

            if(!$request->recommending_office_category_id) {
                return response()->json( [ 'errors' => ['recommending_office_category' => 'Recommending office category is required for this id type'] ], 401 );
            }
            $recommendingOfficeCat = RecommendingOfficeCategory::find($request->recommending_office_category_id);

            if( $recommendingOfficeCat->title == 'MLA' ) {
                if(!$request->recommending_office_mla || 'Select' == $request->recommending_office_mla) {
                    return response()->json( [ 'errors' => ['recommending_office' => 'Recommending office is required'] ], 401 );
                }
                $recommendingOffice = $request->recommending_office_mla;
            } else if( $recommendingOfficeCat->title == 'Minister' ) {
                if(!$request->recommending_office_minister || 'Select' == $request->recommending_office_minister) {
                    return response()->json( [ 'errors' => ['recommending_office' => 'Recommending office is required'] ], 401 );
                }
                $recommendingOffice = $request->recommending_office_minister;
            }
            else{
               if(!$request->recommending_office_input) {
                    return response()->json( [ 'errors' => ['recommending_office' => 'Recommending office is required for this id type'] ], 401 );
                }
                $recommendingOffice = $request->recommending_office_input;
            }
        }
        */

        $postOffice =  $request->post_office ??  $request->post_office_select;
        if(!$postOffice ) {
            return response()->json( [ 'errors' => ['post_office' => 'postOffice is required'] ], 401 );
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

        //use transaction here to make sure number is unique

        $galleryPass = null;
        \DB::transaction( function() use ($request, $person, $recommendingOffice, &$galleryPass, $dob, $postOffice)
        {
            if($request->passid) {
                $galleryPass = GalleryPass::find($request->passid);

                if(!$galleryPass) {
                    return response()->json( [ 'errors' => ['pass_id' => 'Pass not found'] ], 404);
                }
            }
            else {
                $galleryPass = new GalleryPass();
                // $lastNumberOfThisYear = VisitorPass::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'desc')->first();
                //find last number of today
                $lastNumberOfToday = GalleryPass::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
                $lastNumber = $lastNumberOfToday ? $lastNumberOfToday->number : 0;
                $galleryPass->number = $lastNumber + 1;
            }

            $idtype = $request->id_type_id != -1 ? IdType::find($request->id_type_id)->name : null;

           // $galleryPass = new VisitorPass();
            $galleryPass->person_id = $person->id;

            $galleryPass->name = $request->name;
            $galleryPass->gender = $request->gender;

            $galleryPass->dob = $dob;
            $galleryPass->age = $request->age;
            $galleryPass->mobile = $request->mobile;
            $galleryPass->id_type =  $idtype;
            $galleryPass->id_detail = $request->id_detail;
            $galleryPass->address = $request->address;
            $galleryPass->country = $request->country;
            $galleryPass->state = $request->state;
            $galleryPass->pincode = $request->pincode;
            $galleryPass->district = $request->district;
            $galleryPass->post_office = $postOffice;
            $galleryPass->photo = $person->getMedia('photo')->last()?->getUrl() ?? null;

           // $galleryPass->recommending_office_category_id = $request->recommending_office_category_id;
           // $galleryPass->recommending_office = $recommendingOffice;
          //  $galleryPass->pass_valid_from = Carbon::now()->format('Y-m-d H:i:s');
            //$galleryPass->pass_valid_upto = $request->pass_valid_upto;
            $galleryPass->issued_date = Carbon::now()->format('Y-m-d');

            $galleryPass->date_of_visit = Carbon::createFromFormat( 'd.m.Y', $request->date_of_visit)->format( 'Y-m-d' );

            $galleryPass->save();
           // return response()->json( [ 'success' => 'Pass created successfully', 'pass'=> $galleryPass ] );
        });


        return response()->json( [ 'success' => 'Pass created successfully', 'pass'=>$galleryPass ] );
    }

}
