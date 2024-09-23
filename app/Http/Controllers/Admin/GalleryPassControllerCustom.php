<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\IdType;
use App\Models\Member;
use App\Models\Person;
use App\Models\Country;
use App\Models\GalleryPass;
use App\Models\GroupPerson;
use Illuminate\Http\Request;
use App\Models\GuidingOfficer;
use App\Http\Controllers\Controller;
use App\Models\SelfRegistration;
use Illuminate\Support\Facades\Storage;
use App\Models\RecommendingOfficeCategory;
use Symfony\Component\HttpFoundation\Response;

class GalleryPassControllerCustom extends Controller
{
    public function register()
    {
        abort_if(Gate::denies('visitor_pass_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_types = IdType::pluck('name', 'id')
            //->prepend('RECOMMENDED BY', '-1')
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
        //$issued_date = Carbon::createFromFormat('Y-m-d H:i:s', $galleryPass->created_at, 'UTC')->setTimezone('Asia/Kolkata');
        $issued_date = Carbon::now()->setTimezone('Asia/Kolkata');
        $issued_on =  $issued_date->format('d.m.Y');
        $issued_at =  $issued_date->format('H:i a');

        return view('admin.galleryPasses.print', compact('galleryPass', 'issued_at', 'issued_on'));
    }
    public function printCompanion(Request $request)
    {

        \Log::info($request->all());
        $passid = $request->id;
        $person_index = $request->person_index;
        $galleryPass = GalleryPass::with(['person', 'person.id_type:id,name'])
        ->findOrFail($passid);
        \Log::info($galleryPass);
        $issued_date = Carbon::createFromFormat('Y-m-d H:i:s', $galleryPass->created_at, 'UTC')->setTimezone('Asia/Kolkata');
        $issued_on =  $issued_date->format('d.m.Y');
        $issued_at =  $issued_date->format('H:i a');
        $companion = GroupPerson::where('gallery_pass_id', $passid)->where('sl_no', $person_index)->first();
        if(!$companion) {
            dd ('Companion not found-'. $passid . ' ' . $person_index);
        }

        return view('admin.galleryPasses.print_companion', compact('galleryPass', 'issued_at', 'issued_on', 'companion'));
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
        $age =  $request->age ?  $request->age : Carbon::parse($dob)->age;
        $person->name = $request->name;
        $person->gender = $request->gender;
        $person->age = $age;
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

        //get all accompanying persons
        $accompanyingPersons = $request->num_persons ? $request->accompanyingPersons : null;
        \Log::info('accompanyingPersons');
        \Log::info($accompanyingPersons);
        \Log::info($request->all() );


        //use transaction here to make sure number is unique

        $galleryPass = null;
        \DB::transaction( function() use ($request, $person, $age, &$galleryPass, $dob, $postOffice, $accompanyingPersons)
        {
            //if this is not today's pass, create a new token 

            if($request->passid) {
                $galleryPass = GalleryPass::whereDate('created_at', Carbon::today())
                ->where( 'id', $request->passid)->first();
                if(!$galleryPass) {
                 //   return response()->json( [ 'errors' => ['pass_id' => 'Pass not found'] ], 404);
                }
            }

            if(!$galleryPass)
            {
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
            $galleryPass->age = $age;
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

          //  $galleryPass->date_of_visit = Carbon::createFromFormat( 'd.m.Y', $request->date_of_visit)->format( 'Y-m-d' );

            $galleryPass->num_persons = $request->num_persons;
            $galleryPass->save();

            $galleryPass->accompanyingPersons()->delete();
            if($accompanyingPersons){
                $galleryPass->accompanyingPersons()->createMany( $accompanyingPersons );
            }

           // return response()->json( [ 'success' => 'Pass created successfully', 'pass'=> $galleryPass ] );
        });


        return response()->json( [ 'success' => 'Pass created successfully', 'pass'=>$galleryPass ] );
    }
    public function getAjax(Request $request)
    {
        $id = $request->id;
        $pass = GalleryPass::with(['person', 'accompanyingPersons'])->findOrFail($id);
        return response()->json( $pass );
    }

    public function search(Request $request)
    {
        \Log::info('searching in Pass');

        \Log::info($request->all());
        // $queryName = $request->queryName;
        $queryMob = $request->queryMob;
        $queryId = $request->queryId;
        $querySelfRegDate = $request->querySelfRegDate;
        $querySelfRegNum = $request->querySelfRegNum;
        $querysearchTokNum = $request->querysearchTokNum;
        $querySelfRegDate = str_replace( ['.', '/'], '-', $querySelfRegDate);
        if( !$querySelfRegDate) {
            $querySelfRegDate = Carbon::today()->format('Y-m-d');
        }

        $passes = null;
        if(($queryMob || $queryId || $querysearchTokNum ) && $querySelfRegNum == '') {

            $passes = GalleryPass::with(['person', 'accompanyingPersons'])
            ->when($queryMob, function($query) use ($queryMob) {
                return $query->where('mobile', 'like', '%'.$queryMob.'%');
            })
            ->when($queryId, function($query) use ($queryId) {
                return $query->where('id_detail', 'like', '%'.$queryId.'%');
            })
            ->when($querysearchTokNum, function($query) use ($querysearchTokNum, $querySelfRegDate) {
                return $query->where('number', $querysearchTokNum)
                ->whereDate('created_at', $querySelfRegDate);
            })
            ->orderBy('created_at', 'desc')
            // ->when($queryName, function($query) use ($queryName) {
            //     return $query->where('name', 'like', '%'.$queryName.'%');
            // })
            ->get()->transform( function($pass) {
                $idtype = IdType::where( 'name', $pass->id_type)->first();
                $pass->id_type_id = $idtype->id;
                //if pass issued date is not today, then remove accompanying persons
                if( !Carbon::parse($pass->created_at)->isToday() ) {
                    $pass->accompanyingPersons = [];
                }
                return $pass;
            });;
        }

        \Log::info($passes);
        //also search in self registrations if no results found in person
        $selfRegs = collect();
        if( !$passes || ($passes && $passes->count() == 0)) {

            if($queryMob || $queryId || $querySelfRegNum ){

                \Log::info('searching in self registrations');
                //replace dots and slashes in $querySelfRegDate with dashes
            
                $selfRegs = SelfRegistration::with('id_type')
                ->where('pass_type', 'gallery')
                ->when($queryMob, function($query) use ($queryMob) {
                    return $query->where('mobile', 'like', '%'.$queryMob.'%');
                })
                ->when($queryId, function($query) use ($queryId) {
                    return $query->where('id_detail', 'like', '%'.$queryId.'%');
                })
                // ->when($queryName, function($query) use ($queryName) {
                //     return $query->where('name', 'like', '%'.$queryName.'%');
                // })
                ->when($querySelfRegNum &&  $querySelfRegDate, function($query) use ($querySelfRegNum, $querySelfRegDate) {
                    return $query->where('number', $querySelfRegNum)
                    ->whereDate('created_at', $querySelfRegDate);
                })
                ->get();
                }
                    

            \Log::info($selfRegs);

            //if results found, convert them to person
            if($selfRegs->count() > 0) {
                $passes = $selfRegs->map( function($selfReg) {
                    $pass = new GalleryPass();
                    $pass->id = -1; //this denotes pass is not in gallery passes table
                    $pass->name = $selfReg->name;
                    $pass->gender = $selfReg->gender;
                    $pass->dob = $selfReg->dob;
                    $pass->age = $selfReg->age;
                    $pass->mobile = $selfReg->mobile;
                    $pass->email = $selfReg->email;
                    $pass->id_type_id = $selfReg->id_type_id;
                    $pass->id_detail = $selfReg->id_detail;
                    $pass->address = $selfReg->address;
                    $pass->country = $selfReg->country;
                    $pass->state = $selfReg->state;
                    $pass->district = $selfReg->district;
                    $pass->post_office = $selfReg->post_office;
                    $pass->pincode = $selfReg->pincode;
                    $pass->num_persons = $selfReg->group_persons;
                    return $pass;
                });
            }
        }
        if(!$passes) {
            $passes = [];
        }
        return response()->json( $passes );
    }


}
