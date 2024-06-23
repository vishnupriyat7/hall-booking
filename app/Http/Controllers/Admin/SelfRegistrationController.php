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
use Illuminate\Support\Facades\Storage;

class SelfRegistrationController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('self_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SelfRegistration::with(['id_type', 'visiting_office_category'])->select(sprintf('%s.*', (new SelfRegistration)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'self_registration_show';
                $editGate      = 'self_registration_edit';
                $deleteGate    = 'self_registration_delete';
                $crudRoutePart = 'self-registrations';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? SelfRegistration::GENDER_SELECT[$row->gender] : '';
            });

            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->addColumn('id_type_name', function ($row) {
                return $row->id_type ? $row->id_type->name : '';
            });

            $table->editColumn('id_detail', function ($row) {
                return $row->id_detail ? $row->id_detail : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('country', function ($row) {
                return $row->country ? SelfRegistration::COUNTRY_SELECT[$row->country] : '';
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : '';
            });
            $table->editColumn('pincode', function ($row) {
                return $row->pincode ? $row->pincode : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? SelfRegistration::PURPOSE_SELECT[$row->purpose] : '';
            });

            $table->addColumn('visiting_office_category_title', function ($row) {
                return $row->visiting_office_category ? $row->visiting_office_category->title : '';
            });

            $table->editColumn('district', function ($row) {
                return $row->district ? $row->district : '';
            });
            $table->editColumn('post_office', function ($row) {
                return $row->post_office ? $row->post_office : '';
            });
            $table->editColumn('visiting_office', function ($row) {
                return $row->visiting_office ? $row->visiting_office : '';
            });
	      $table->editColumn('number', function ($row) {
                return $row->number ? $row->number : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'id_type', 'photo', 'visiting_office_category']);

            return $table->make(true);
        }

        return view('admin.selfRegistrations.index');
    }



    public function search(Request $request)
    {
        \Log::info('searching in Person');

        \Log::info($request->all());
        // $queryName = $request->queryName;
        $queryMob = $request->queryMob;
        $queryId = $request->queryId;
        $querySelfRegDate = $request->querySelfRegDate;
        $querySelfRegNum = $request->querySelfRegNum;

        $people = null;
        if(($queryMob || $queryId ) && $querySelfRegNum == '') {

            $people = Person::with(['id_type', 'personVisitorPassLatest'])
            ->withCount('personVisitorPasses')
            ->when($queryMob, function($query) use ($queryMob) {
                return $query->where('mobile', 'like', '%'.$queryMob.'%');
            })
            ->when($queryId, function($query) use ($queryId) {
                return $query->where('id_detail', 'like', '%'.$queryId.'%');
            })
            // ->when($queryName, function($query) use ($queryName) {
            //     return $query->where('name', 'like', '%'.$queryName.'%');
            // })
            ->get();
        }

        \Log::info($people);
        //also search in self registrations if no results found in person
        $selfRegs = [];
        if( !$people || ($people && $people->count() == 0)) {
            \Log::info('searching in self registrations');
            //replace dots and slashes in $querySelfRegDate with dashes
            $querySelfRegDate = str_replace( ['.', '/'], '-', $querySelfRegDate);

            $selfRegs = SelfRegistration::with('id_type')
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
            \Log::info($selfRegs);

            //if results found, convert them to person
            if($selfRegs->count() > 0) {
                $people = $selfRegs->map( function($selfReg) {
                    $person = new Person();
                    $person->id = -1; //this denotes person does not exist in person table
                    $person->name = $selfReg->name;
                    $person->gender = $selfReg->gender;
                    $person->dob = $selfReg->dob;
                    $person->age = $selfReg->age;
                    $person->mobile = $selfReg->mobile;
                    $person->email = $selfReg->email;
                    $person->id_type_id = $selfReg->id_type_id;
                    $person->id_detail = $selfReg->id_detail;
                    $person->address = $selfReg->address;
                    $person->country = $selfReg->country;
                    $person->state = $selfReg->state;
                    $person->district = $selfReg->district;
                    $person->post_office = $selfReg->post_office;
                    $person->pincode = $selfReg->pincode;
                    $person->group_persons = $selfReg->group_persons;
                    return $person;
                });
            }
        }
        if(!$people) {
            $people = [];
        }
        return response()->json( $people );
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



    public function show(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistration->load('id_type', 'visiting_office_category');

        return view('admin.selfRegistrations.show', compact('selfRegistration'));
    }

    public function destroy(SelfRegistration $selfRegistration)
    {
        abort_if(Gate::denies('self_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfRegistration->delete();

        return back();
    }
}
