<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\IdType;
use App\Models\Person;
use App\Models\VisitorPass;
use Illuminate\Http\Request;
use App\Models\VisitingOffice;
use App\Models\SelfRegistration;
use App\Http\Controllers\Controller;
use App\Models\VisitingOfficeCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreSelfRegistrationRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateSelfRegistrationRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\MassDestroySelfRegistrationRequest;
use App\Models\RecommendingOfficeCategory;

class SelfRegistrationController extends Controller
{
    use MediaUploadingTrait;


    public function store(Request $request)
    {
        //$selfRegistration = SelfRegistration::create($request->all());

        // $validator = Validator::make( $request->all(),
        // [
        //     'company_name' => 'required|string|max:255',
        // ],
        // [
        //     'company_name.required' => 'Company name is required',
        //     'company_name.string' => 'Company name should be string',
        //     'company_name.max' => 'Company name should not exceed 255 characters',
        // ]);

        // if ( $validator->fails() ) {
        //     return response()->json( [ 'errors' => $validator->errors() ] );
        // }
        //check if personid exists

        $personid = $request->personid;
        $person = null;
        if($personid) {
            $person = Person::find($personid);
            if(!$person) {
                return response()->json( [ 'errors' => ['personid' => 'Person not found'] ], 404);
            }
            //test
          //  return response()->json( [ 'errors' => ['personid' => 'Person found'] ], 401 );
          //update person


        } else {

            $person = Person::where('mobile', $request->mobile)
            ->when($request->id_type_id != -1, function($query) use ($request) {
                return $query->orwhere('id_detail', $request->id_detail);
            })
            ->first();

            if($person) {
                return response()->json( [ 'errors' => ['personid' => 'Person already exists with same mobile number or id number'] ], 401 );
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

        $person->name = $request->name;
        $person->gender = $request->gender;
        $person->age = $request->age;
        $person->mobile = $request->mobile;
        $person->id_type_id = $request->id_type_id == -1 || $request->id_type_id == '' ? null : $request->id_type_id;
        $person->id_detail = $request->id_detail;
        $person->address = $request->address;
        $person->country = $request->country;
        $person->state = $request->state;
        $person->pincode = $request->pincode;
        $person->district = $request->district;
        $person->post_office = $request->post_office;
        $person->save();

        // if ($request->input('photo', false)) {
        //     $person->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        // }

        // if ($media = $request->input('ck-media', false)) {
        //     Media::whereIn('id', $media)->update(['model_id' => $person->id]);
        // }

        //now create a pass

        //use transaction here to make sure number is unique


        $visitorPass = null;
        \DB::transaction( function() use ($request, $person, $visitingOffice, $recommendingOffice, &$visitorPass)
        {

            if($request->passid) {
                $visitorPass = VisitorPass::find($request->passid);

                if(!$visitorPass) {
                    return response()->json( [ 'errors' => ['pass_id' => 'Pass not found'] ], 404);
                }
            }
            else {
                $visitorPass = new VisitorPass();
                $lastNumberOfThisYear = VisitorPass::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'desc')->first();
                $lastNumber = $lastNumberOfThisYear ? $lastNumberOfThisYear->number : 0;
                $visitorPass->number = $lastNumber + 1;
            }

           // $visitorPass = new VisitorPass();
            $visitorPass->person_id = $person->id;
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

    public function search(Request $request)
    {
        $queryName = $request->queryName;
        $queryMob = $request->queryMob;
        $queryId = $request->queryId;

        $people = Person::with('id_type')
        ->when($queryMob, function($query) use ($queryMob) {
            return $query->where('mobile', 'like', '%'.$queryMob.'%');
        })
        ->when($queryId, function($query) use ($queryId) {
            return $query->where('id_detail', 'like', '%'.$queryId.'%');
        })
        ->when($queryName, function($query) use ($queryName) {
            return $query->where('name', 'like', '%'.$queryName.'%');
        })
        ->get();

        return response()->json(
            $people,
        );
        return view('admin.visitorPasses.search', compact('people'));
    }


    public function update(UpdateSelfRegistrationRequest $request, SelfRegistration $selfRegistration)
    {
        $selfRegistration->update($request->all());

        if ($request->input('photo', false)) {
            if (! $selfRegistration->photo || $request->input('photo') !== $selfRegistration->photo->file_name) {
                if ($selfRegistration->photo) {
                    $selfRegistration->photo->delete();
                }
                $selfRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($selfRegistration->photo) {
            $selfRegistration->photo->delete();
        }

        return redirect()->route('admin.self-registrations.index');
    }



    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('self_registration_create') && Gate::denies('self_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SelfRegistration();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
