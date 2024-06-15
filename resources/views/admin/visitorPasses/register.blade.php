@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')
<div class="card">

    <div class="card-body">
        <form class="form-inline" id="searchForm" method="GET" action="{{ route('admin.self-registrations.search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="Name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="searchName" id="searchName">

            </div>
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="Mobile" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="searchMob" id="searchMob" >

            </div>
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="ID" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="searchId" id="searchId">

            </div>
            <button class="btn btn-primary" type="submit">
                Find
            </button>
        </form>
        <!-- Modal for displaying search results -->
        <div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultsModalLabel">Search Results</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Mobile</th>
                                    <th>ID Card</th>
                                    <th>Address</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody id="resultsList">
                                <!-- Results will be appended here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <div class="card" id="app">
        <div class="card-header">
            {{ trans('cruds.selfRegistration.title_singular') }}
        </div>

        <!-- <pass-registration></pass-registration> -->

        <div class="card-body">
            <form id="registerForm" method="POST" action="{{ route('admin.self-registrations.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col ">
                        <label class="required" for="name">{{ trans('cruds.selfRegistration.fields.name') }}</label>
                        <input autocomplete="new-password" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.name_helper') }}</span>
                    </div>
                    <input type="hidden" name="personid" id="personid" >

                    <div class="form-group col">
                        <label class="required">{{ trans('cruds.selfRegistration.fields.gender') }}</label>
                        <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender" required>
                            <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\SelfRegistration::GENDER_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gender'))
                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.gender_helper') }}</span>
                    </div>


                    <div class="form-group col">
                        <label class="required" for="age">{{ trans('cruds.selfRegistration.fields.age') }}</label>
                        <input autocomplete="new-password" class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', '') }}" step="1" required>
                        @if($errors->has('age'))
                        <span class="text-danger">{{ $errors->first('age') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.age_helper') }}</span>
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col">
                        <label class="required" for="mobile">{{ trans('cruds.selfRegistration.fields.mobile') }}</label>
                        <input autocomplete="new-password" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', '') }}" required>
                        @if($errors->has('mobile'))
                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.mobile_helper') }}</span>
                    </div>
                    <div class="form-group col ">
                        <label for="id_type_id">{{ trans('cruds.selfRegistration.fields.id_type') }}</label>
                        <select required class="form-control {{ $errors->has('id_type') ? 'is-invalid' : '' }}" name="id_type_id" id="id_type_id">
                            @foreach($id_types as $id => $entry)
                            <option value="{{ $id }}" {{ old('id_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('id_type'))
                        <span class="text-danger">{{ $errors->first('id_type') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.id_type_helper') }}</span>
                    </div>
                    <div class="form-group col">
                        <label for="id_detail">{{ trans('cruds.selfRegistration.fields.id_detail') }}</label>
                        <input autocomplete="new-password" class="form-control {{ $errors->has('id_detail') ? 'is-invalid' : '' }}" type="text" name="id_detail" id="id_detail" value="{{ old('id_detail', '') }}">
                        @if($errors->has('id_detail'))
                        <span class="text-danger">{{ $errors->first('id_detail') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.id_detail_helper') }}</span>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col">
                        <label for="recommending_office_category_id">{{ trans('cruds.selfRegistration.fields.recommending_office_category') }}</label>
                        <select class="form-control {{ $errors->has('recommending_office_category') ? 'is-invalid' : '' }}" name="recommending_office_category_id" id="recommending_office_category_id" required>
                            @foreach($recommending_office_categories as $id => $entry)
                            <option value="{{ $id }}" {{ old('recommending_office_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('recommending_office_category'))
                        <span class="text-danger">{{ $errors->first('recommending_office_category') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.recommending_office_category_helper') }}</span>
                    </div>
                    <div class="form-group col">
                        <label for="recommending_office">{{ trans('cruds.selfRegistration.fields.recommending_office') }}</label>
                        <select class="form-control select2 {{ $errors->has('recommending_office') ? 'is-invalid' : '' }}" name="recommending_office" id="recommending_office"> </select>
                        <input class="form-control {{ $errors->has('recommending_office') ? 'is-invalid' : '' }}" name="recommending_office_input" id="recommending_office_input" hidden>

                        @if($errors->has('recommending_office'))
                        <span class="text-danger">{{ $errors->first('recommending_office') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.recommending_office_helper') }}</span>
                    </div>

                </div>


                <div class="row">
                    <div class="col">

                        <div class="form-group">
                            <label for="address">{{ trans('cruds.selfRegistration.fields.address') }}</label>
                            <textarea autocomplete="new-password" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address') }}</textarea>
                            @if($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfRegistration.fields.address_helper') }}</span>
                        </div>


                    </div>

                    <div class="col">


                        <div class="form-group ">
                            <label class="required" for="pincode">{{ trans('cruds.selfRegistration.fields.pincode') }}</label>
                            <input autocomplete="new-password" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', '') }}" required>
                            @if($errors->has('pincode'))
                            <span class="text-danger">{{ $errors->first('pincode') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfRegistration.fields.pincode_helper') }}</span>
                        </div>

                        <div class="form-group ">
                            <label for="post_office">{{ trans('cruds.selfRegistration.fields.post_office') }}</label>
                            <input class="form-control {{ $errors->has('post_office') ? 'is-invalid' : '' }}" type="text" name="post_office" id="post_office" value="{{ old('post_office', '') }}">
                            @if($errors->has('post_office'))
                            <span class="text-danger">{{ $errors->first('post_office') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfRegistration.fields.post_office_helper') }}</span>
                        </div>



                    </div>
                </div>


                <div class="row">

                    <div class="form-group col">
                        <label>{{ trans('cruds.selfRegistration.fields.country') }}</label>
                        <select class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" id="country">
                            <!-- <option value disabled {{ old('country', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option> -->
                            @foreach(App\Models\SelfRegistration::COUNTRY_SELECT as $key => $label)
                            <option value="{{ $label }}" {{ old('country', 'India') === (string) $label ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('country'))
                        <span class="text-danger">{{ $errors->first('country') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.country_helper') }}</span>
                    </div>

                    <div class="form-group col">
                        <label for="state">{{ trans('cruds.selfRegistration.fields.state') }}</label>

                        <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state">
                        @if($errors->has('state'))

                        <span class="text-danger">{{ $errors->first('state') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.state_helper') }}</span>
                    </div>
                    <div class="form-group col">
                        <label for="district">{{ trans('cruds.selfRegistration.fields.district') }}</label>
                        <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', '') }}">
                        @if($errors->has('district'))
                        <span class="text-danger">{{ $errors->first('district') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.district_helper') }}</span>
                    </div>

                </div>



                <div class="form-group">
                    <label for="photo">{{ trans('cruds.selfRegistration.fields.photo') }}</label>
                    <div class="needsclick {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.selfRegistration.fields.photo_helper') }}</span>
                </div>

                <div class="row">


                    <div class="form-group col">
                        <label class="required">{{ trans('cruds.selfRegistration.fields.purpose') }}</label>
                        <select class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose" id="purpose" required>
                            <option value disabled {{ old('purpose', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\SelfRegistration::PURPOSE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('purpose', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('purpose'))
                        <span class="text-danger">{{ $errors->first('purpose') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.purpose_helper') }}</span>
                    </div>
                    <div class="form-group col">
                        <label for="date_of_visit">{{ trans('cruds.selfRegistration.fields.date_of_visit') }}</label>
                        <input class="form-control date {{ $errors->has('date_of_visit') ? 'is-invalid' : '' }}" type="text" name="date_of_visit" id="date_of_visit" value="{{ old('date_of_visit') }}">
                        @if($errors->has('date_of_visit'))
                        <span class="text-danger">{{ $errors->first('date_of_visit') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.date_of_visit_helper') }}</span>
                    </div>

                </div>
                <div class="row">

                    <div class="form-group col">
                        <label class="required" for="visiting_office_category_id">{{ trans('cruds.selfRegistration.fields.visiting_office_category') }}</label>
                        <select class="form-control {{ $errors->has('visiting_office_category') ? 'is-invalid' : '' }}" name="visiting_office_category_id" id="visiting_office_category_id" required>
                            <!-- <option disabled>Please Select</optionld> -->

                            @foreach($visiting_office_categories as $id => $entry)
                            <option value="{{ $id }}" {{ old('visiting_office_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('visiting_office_category'))
                        <span class="text-danger">{{ $errors->first('visiting_office_category') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.visiting_office_category_helper') }}</span>
                    </div>
                    <div class="form-group col">
                        <label class="required" for="visiting_office">{{ trans('cruds.selfRegistration.fields.visiting_office') }}</label>
                        <select class="form-control select2 {{ $errors->has('visiting_office') ? 'is-invalid' : '' }}" name="visiting_office" id="visiting_office"> </select>
                        <input class="form-control {{ $errors->has('visiting_office') ? 'is-invalid' : '' }}" name="visiting_office_input" id="visiting_office_input" hidden>

                        @if($errors->has('visiting_office'))
                        <span class="text-danger">{{ $errors->first('visiting_office') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.visiting_office_helper') }}</span>
                    </div>

                </div>


                <div class="form-group">

                    <button class="btn btn-primary" type="submit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="spinnerbtn"></span>
                        Submit
                    </button>
                </div>
            </form>
            <div class="alert alert-danger" id="alert" style="display:none;">
                <ul class="list-unstyled" id="myerror">
                </ul>
            </div>
        </div>
    </div>



    @endsection

    @section('scripts')
    <script src="{{ asset('js/country.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>

    <script>
         function fetchPin(pin) {

            // Creating Our XMLHttpRequest object
            let xhr = new XMLHttpRequest();
            //let pin = e.target.value
            if (pin.length != 6) {
                //alert("Pincode should be 6 digits" + pin.length + " " + pin);
                return;
            }
            document.getElementById("post_office").value = "";
            document.getElementById("district").value = "";
            document.getElementById("state").value = "";
            // Making our connection
            let url = 'https://api.postalpincode.in/pincode/' + pin;
            xhr.open("GET", url, true);

            // function execute after request is successful
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    let data = JSON.parse(this.responseText);
                    if (data[0].Status == "Success") {
                        let postOffice = data[0].PostOffice[0];
                        document.getElementById("post_office").value = postOffice.Name;
                        document.getElementById("district").value = postOffice.District;
                        document.getElementById("state").value = postOffice.State;
                    }
                }
            }
            // Sending our request
            xhr.send();
            }

    </script>

    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                let queryName = $('#searchName').val();
                let queryId = $('#searchId').val();
                let queryMob = $('#searchMob').val();
                if (!queryName && !queryId && !queryMob) {
                    alert('Please enter at least one search criteria');
                    return;
                }
                $.ajax({
                    url: "{{ route('admin.self-registrations.search') }}",
                    type: 'GET',
                    data: {
                        queryName: queryName,
                        queryId: queryId,
                        queryMob: queryMob
                    },
                    success: function(data) {
                        let resultsList = $('#resultsList');
                        resultsList.empty();
                        data.forEach(function(item) {
                            resultsList.append(
                                `<tr>
                                    <td>${item.name}</td>
                                    <td>${item.age}</td>
                                    <td>${item.mobile}</td>
                                    <br>${item.id_card_type || ''} <br>
                                    <td>${item.id_detail || ''}</td>
                                    <td> <small> ${item.address} <br>
                                      ${item.district} <br>
                                      ${item.pincode}</small></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm select-record"
                                            data-personid="${item.id}"
                                            data-name="${item.name}"
                                            data-age="${item.age}"
                                            data-gender="${item.gender}"
                                            data-mobile="${item.mobile}"
                                            data-id_type_id="${item.id_type_id}"
                                            data-id_detail="${item.id_detail}"
                                            data-address="${item.address}"
                                            data-pincode="${item.pincode}">
                                            Select
                                        </button>
                                    </td>
                                </tr>`
                            );
                        });
                        $('#resultsModal').modal('show');
                    }
                });
            });

            $(document).on('click', '.select-record', function() {
                let personid = $(this).data('personid');
                let name = $(this).data('name');
                let gender = $(this).data('gender');
                let age = $(this).data('age');
                let mobile = $(this).data('mobile')?.toString();
                let id_type_id = $(this).data('id_type_id');
                let id_detail = $(this).data('id_detail')?.toString();
                let address = $(this).data('address');
                let pincode = $(this).data('pincode')?.toString();
                $('#personid').val(personid);
                $('#name').val(name);
                $('#mobile').val(mobile);
                $('#gender').val(gender);
                $('#age').val(age);
                $('#id_type_id').val(id_type_id);
                $('#id_detail').val(id_detail);
                $('#address').val(address);
                $('#pincode').val(pincode);
                $('#resultsModal').modal('hide');
                fetchPin(pincode);
            });

            $('#registerForm').ajaxForm({
                beforeSend: function() {
                    var percentage = '0';
                },

                beforeSubmit: function(arr, $form, options) {
                    // The array of form data takes the following form:
                    // [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]

                    // return false to cancel submit
                    //alert( JSON.stringify( arr));
                    $('#myerror').empty()
                    let valid = true;
                    for (const item of arr) {
                        if (item?.name == 'date') {
                            if (!item?.value) {
                                $('#myerror').append('<li>Fill all fields</li>');
                                valid = false;
                                break;
                            }

                        }
                    }

                    if (!valid) {
                        $('#alert').show();
                    } else {
                        $('#spinnerbtn').show();
                    }

                    return valid;

                },
                uploadProgress: function(event, position, total, percentComplete) {
                    // var percentage = percentComplete;
                    // if(  percentage > 90 ){
                    //     percentage = 90
                    //  }
                    //  $('.progress .progress-bar').css("width", percentage+'%', function() {
                    //   return $(this).attr("aria-valuenow", percentage) + "%";
                    //  })
                },
                complete: function(xhr) {

                    let jsonResponse = JSON.parse(xhr.responseText);
                    //alert(jsonResponse);

                    //console.log('File has uploaded');
                    if (jsonResponse?.errors) {
                        $('#spinnerbtn').hide();
                        $('#myerror').empty();
                        for (const key in jsonResponse.errors) {
                            $('#myerror').append('<li>' + jsonResponse.errors[key] + '</li>');
                        }

                        $('#alert').show();

                    } else {
                        // var i = window.location.href.lastIndexOf("/");
                        // window.location = window.location.href.substr(0, i)

                    }
                }
            });


    });

    </script>

    <script>
        var ministers = {!! json_encode($ministers) !!};
        var mlas = {!! json_encode($mlas) !!};

        //  var visiting_office_instance =  NiceSelect.bind(document.getElementById("visiting_office"), {searchable: true});

        console.log(ministers);

        window.onload = function() {
            const selectCountry = document.getElementById("country");
            const visiting_office_category = document.getElementById("visiting_office_category_id");
            const visiting_office = document.getElementById("visiting_office");
            const visiting_office_input = document.getElementById("visiting_office_input");

            const recommending_office_category = document.getElementById("recommending_office_category_id");
            const recommending_office = document.getElementById("recommending_office");
            const recommending_office_input = document.getElementById("recommending_office_input");

            const date_of_visit = document.getElementById("date_of_visit");
            date_of_visit.value = moment().format("DD.MM.YYYY");

            const selectDistrict = document.getElementById("district");
            const pinCtrl = document.getElementById("pincode");
            const idType = document.getElementById("id_type_id");


            // selectDistrict.disabled = true;

            //Add State Value to State Select option
            /*data.states.forEach((value) => {
              selectState.appendChild(createOption(value.state, value.state));
            });
            */

            //   selectCountry.addEventListener("change", function (e) {
            //     //selectState.disabled = false;
            //   //  stateListOptions.innerHTML = "";
            //     if(e.target.value === "India"){
            //        // alert("India");
            //        var options = '';
            //       data.states.forEach((value) => {
            //        // options += '<option value="' + value.state + '" />';
            //         //selectState.appendChild(createOption(value.state, value.state));
            //       });
            //     }
            //   });

            //Create New Option Tag With Value
            function createOption(displayMember, valueMember) {
                const newOption = document.createElement("option");
                newOption.value = valueMember;
                newOption.text = displayMember;
                return newOption;
            }


            pinCtrl.addEventListener("input", function(e) {
                fetchPin(e.target.value);
            });
            pinCtrl.addEventListener("change", function(e) {
                fetchPin(e.target.value);
            });


            idType.addEventListener("change", function(e) {
                // alert(e.target.value);
                let id = e.target.value
                let id_detail = document.getElementById("id_detail");
                if (id != -1) {
                    id_detail.setAttribute("required", "");
                    recommending_office_category.removeAttribute('required');

                } else {
                    id_detail.removeAttribute('required');
                    recommending_office_category.setAttribute("required", "");

                }
            });

            visiting_office_category.addEventListener("input", function(e) {
                let office = e.target.value
                visiting_office.innerHTML = "";
                visiting_office_input.style.display = 'none';
                visiting_office.removeAttribute('required');
                visiting_office_input.removeAttribute('required');
                if ('MLA' == office) {
                    jQuery("#visiting_office").select2().next().show();
                    visiting_office.innerHTML = "<option> Select </option>";
                    visiting_office.setAttribute("required", "");
                    mlas.forEach(({
                        id,
                        name
                    }) => {
                        visiting_office.append(createOption(name, id));
                    });
                } else if ('Minister' == office) {
                    jQuery("#visiting_office").select2().next().show();
                    visiting_office.innerHTML = "<option> Select </option>";
                    visiting_office.setAttribute("required", "");

                    ministers.forEach(({
                        id,
                        name
                    }) => {
                        visiting_office.append(createOption(name, id));
                    });
                } else if (['Legislature Secretary', 'Speaker', 'Deputy Speaker', 'Chief Minister', 'Leader of Opposition'].indexOf(office) !== -1) {
                    let officename = 'O/o ' + office;
                    visiting_office.setAttribute("required", "");
                    jQuery("#visiting_office").select2().next().show();
                    visiting_office.append(createOption(officename, officename));
                } else {
                    visiting_office.style.display = 'none';
                    visiting_office_input.style.display = 'block';
                    visiting_office_input.hidden = false;
                    visiting_office_input.setAttribute("required", "");
                    jQuery("#visiting_office").select2().next().hide();


                    // alert("Please select a valid office category");

                    // visiting_office.disabled = true;
                }
                // visiting_office_instance.update();
            });


            recommending_office_category.addEventListener("input", function(e) {
                let office = e.target.value
                recommending_office.innerHTML = "";
                recommending_office_input.style.display = 'none';
                //recommending_office.removeAttribute('required');
                jQuery("#recommending_office").select2().prop('required', false);
                recommending_office_input.removeAttribute('required');
                if ('MLA' == office) {
                    jQuery("#recommending_office").select2().next().show();
                    jQuery("#recommending_office").select2().prop('required', true);
                    //make recommending_office required


                    //recommending_office.setAttribute("required", "");
                    recommending_office.innerHTML = "<option> Select </option>";
                    mlas.forEach(({
                        id,
                        name
                    }) => {
                        recommending_office.append(createOption(name, id));
                    });
                } else if ('Minister' == office) {
                    jQuery("#recommending_office").select2().next().show();
                    jQuery("#recommending_office").select2().attr('required', true);
                    recommending_office.innerHTML = "<option> Select </option>";
                    ministers.forEach(({
                        id,
                        name
                    }) => {
                        recommending_office.append(createOption(name, id));
                    });
                } else if (['Legislature Secretary', 'Speaker', 'Deputy Speaker', 'Chief Minister', 'Leader of Opposition'].indexOf(office) !== -1) {
                    let officename = 'O/o ' + office;
                    jQuery("#recommending_office").select2().next().show();
                    jQuery("#recommending_office").select2().attr('required', true);
                    recommending_office.append(createOption(officename, officename));
                } else {
                    recommending_office.style.display = 'none';
                    recommending_office_input.style.display = 'block';
                    recommending_office_input.hidden = false;
                    recommending_office_input.setAttribute("required", "");
                    jQuery("#recommending_office").select2().next().hide();
                    // alert("Please select a valid office category");

                    // visiting_office.disabled = true;
                }
                // visiting_office_instance.update();
            });


        };
    </script>
    @endsection
