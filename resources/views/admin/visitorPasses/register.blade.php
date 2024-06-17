@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<style>
    #video {
        border: 1px solid black;
        /* box-shadow: 2px 2px 3px black; */
        width: 320px;
        height: 240px;
    }

    #photo {
        border: 1px solid black;
        /* box-shadow: 2px 2px 3px black; */
        width: 320px;
        height: 240px;
    }

    #canvas {
        display: none;
    }

    .camera {
        width: 340px;
        display: inline-block;
    }

    .output {
        width: 340px;
        display: inline-block;
        vertical-align: top;
    }


    .modal-dialog {
        width: auto !important;
    max-width: 850px; 
    }


</style>

@endsection

@section('content')
<div class="card">

    <div class="card-body">
        <form class="form-inline" id="searchForm" method="GET" action="{{ route('admin.self-registrations.search') }}" enctype="multipart/form-data">
            @csrf
            <!-- <div class="form-group ">
                <input autocomplete="new-password" placeholder="Name" class="form-control {{ $errors->has('searchName') ? 'is-invalid' : '' }}" type="text" name="searchName" id="searchName">

            </div> -->
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="Mobile" class="form-control {{ $errors->has('searchMob') ? 'is-invalid' : '' }}" type="text" name="searchMob" id="searchMob">

            </div>
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="ID" class="form-control {{ $errors->has('searchId') ? 'is-invalid' : '' }}" type="text" name="searchId" id="searchId">

            </div>
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="Self Reg Date" class="form-control {{ $errors->has('searchSelfRegDate') ? 'is-invalid' : '' }}" type="date" name="searchSelfRegDate" id="searchSelfRegDate">
            </div>
            <div class="form-group ">
                <input autocomplete="new-password" placeholder="Self Reg No" class="form-control {{ $errors->has('searchSelfRegNum') ? 'is-invalid' : '' }}" type="number" name="searchSelfRegNum" id="searchSelfRegNum">
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

        <!-- show if pass is issued to this person  -->
         <div id='pass_issed_to_this_person'>

         </div>

    </div>
</div>


<div class="card" id="app">

    <div class="card-body">
        <form id="registerForm" method="POST" action="{{ route('admin.self-registrations.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-4">
                    <label class="required" for="name">{{ trans('cruds.selfRegistration.fields.name') }}</label>
                    <input autocomplete="new-password" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.selfRegistration.fields.name_helper') }}</span>
                </div>

                <div class="form-group col-2">
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

                <div class="form-group col">
                <label for="dob">{{ trans('cruds.person.fields.dob') }}</label>
                <input class="form-control date {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="text" name="dob" id="dob" value="{{ old('dob') }}">
                @if($errors->has('dob'))
                    <span class="text-danger">{{ $errors->first('dob') }}</span>
                @endif


                </div>

            </div>

            <div class="row">
            <div class="form-group col">
            <label class="required" for="mobile">{{ trans('cruds.selfRegistration.fields.mobile') }}</label>
                    <input autocomplete="new-password" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', '') }}" required>
                    @if($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                    @endif
            </div>
            <div class="form-group col">
                <label for="email">{{ trans('cruds.person.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.email_helper') }}</span>
            </div>
            </div>


            <div class="row">


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


                <div class="form-group col">
                    <label for="recommending_office_category_id">Recommendation</label>
                    <select class="form-control {{ $errors->has('recommending_office_category') ? 'is-invalid' : '' }}" name="recommending_office_category_id" id="recommending_office_category_id">
                        @foreach($recommending_office_categories as $id => $title)
                        <option value="{{ $id }}" {{ old('recommending_office_category_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('recommending_office_category'))
                    <span class="text-danger">{{ $errors->first('recommending_office_category') }}</span>
                    @endif
                </div>
                <div class="form-group col">
                    <label for="recommending_office">Recommending Office</label>

                    <select data-live-search="true" class="form-control selectpicker {{ $errors->has('recommending_office_mla') ? 'is-invalid' : '' }}" name="recommending_office_mla" id="recommending_office_mla">
                        <option value="Select">Select</option>
                        @foreach($mlas as $id => $entry)
                        <option value="{{ $entry->name }}">{{ $entry->name }}</option>
                        @endforeach
                    </select>
                    <select data-live-search="true" class="form-control selectpicker {{ $errors->has('recommending_office_minister') ? 'is-invalid' : '' }}" name="recommending_office_minister" id="recommending_office_minister">
                        <option value="Select">Select</option>
                        @foreach($ministers as $id => $entry)
                        <option value="{{ $entry->name }}">{{ $entry->name }}</option>
                        @endforeach
                    </select>

                    <input class="form-control {{ $errors->has('recommending_office') ? 'is-invalid' : '' }}" name="recommending_office_input" id="recommending_office_input">

                    @if($errors->has('recommending_office'))
                    <span class="text-danger">{{ $errors->first('recommending_office') }}</span>
                    @endif
                </div>

            </div>


            <div class="row d-flex align-items-stretch">
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

                <div class="col d-flex flex-column justify-content-between ">

                    <div class="row">
                    <div class="form-group col ">
                        <label class="required" for="pincode">{{ trans('cruds.selfRegistration.fields.pincode') }}</label>
                        <input autocomplete="new-password" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', '') }}" required>
                        @if($errors->has('pincode'))
                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.pincode_helper') }}</span>
                    </div>

                    <div class="form-group col">
                        <label for="post_office">{{ trans('cruds.selfRegistration.fields.post_office') }}</label>
                        <input class="form-control {{ $errors->has('post_office') ? 'is-invalid' : '' }}" type="text" name="post_office" id="post_office" value="{{ old('post_office', '') }}">
                        @if($errors->has('post_office'))
                        <span class="text-danger">{{ $errors->first('post_office') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.selfRegistration.fields.post_office_helper') }}</span>
                    </div>
                    </div>

                    <!-- country and state  -->

                    <div class="row">
                    <div class="form-group col ">
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
                    </div>

                    <div class="form-group col">
                    <label for="state">{{ trans('cruds.selfRegistration.fields.state') }}</label>

                    <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state">
                    @if($errors->has('state'))

                    <span class="text-danger">{{ $errors->first('state') }}</span>
                    @endif

                    </div>
                    </div>


                </div>
            </div>




            <div class="row">


                <div class="form-group col-3">
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
                <div class="form-group col-3">
                    <label for="date_of_visit">{{ trans('cruds.selfRegistration.fields.date_of_visit') }}</label>
                    <input class="form-control date {{ $errors->has('date_of_visit') ? 'is-invalid' : '' }}" type="text" name="date_of_visit" id="date_of_visit" value="{{ old('date_of_visit') }}">
                    @if($errors->has('date_of_visit'))
                    <span class="text-danger">{{ $errors->first('date_of_visit') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.selfRegistration.fields.date_of_visit_helper') }}</span>
                </div>

                <div class="form-group col-6">
                            <label for="district">{{ trans('cruds.selfRegistration.fields.district') }}</label>
                            <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', '') }}">
                            @if($errors->has('district'))
                            <span class="text-danger">{{ $errors->first('district') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfRegistration.fields.district_helper') }}</span>
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
                    <select data-live-search="true" class="form-control selectpicker {{ $errors->has('visiting_office_mla') ? 'is-invalid' : '' }}" name="visiting_office_mla" id="visiting_office_mla">
                        <option value="Select">Select</option>
                        @foreach($mlas as $id => $entry)
                        <option value="{{ $entry->name }}">{{ $entry->name }}</option>
                        @endforeach
                    </select>
                    <select data-live-search="true" class="form-control selectpicker {{ $errors->has('visiting_office_minister') ? 'is-invalid' : '' }}" name="visiting_office_minister" id="visiting_office_minister">
                        <option value="Select">Select</option>
                        @foreach($ministers as $id => $entry)
                        <option value="{{ $entry->name }}">{{ $entry->name }}</option>
                        @endforeach
                    </select>
                    <input class="form-control {{ $errors->has('visiting_office') ? 'is-invalid' : '' }}" name="visiting_office_input" id="visiting_office_input">

                    @if($errors->has('visiting_office'))
                    <span class="text-danger">{{ $errors->first('visiting_office') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.selfRegistration.fields.visiting_office_helper') }}</span>
                </div>

            </div>

            <div class="row d-flex justify-content-center">

                <div class="camera">
                    <video id="video" muted autoplay="autoplay" playsinline="playsinline" webkit-playsinline>Video stream not available.</video>
                </div>
                <canvas id="canvas"> </canvas>
                <div class="output">
                    <img id="photo" alt="The screen capture will appear in this box." />
                </div>
            </div>

            <div class="form-group d-flex justify-content-center">

                <button class="btn btn-primary" type="submit" id='register-print-btn'>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="spinnerbtn"></span>
                    Register and Print
                </button>

                <a class="ml-2 btn btn-success" href="{{ route('admin.visitor-passes.register') }}">
                    New Registration
                </a>

                <button class="ml-2 btn btn-warning" type='button' id="startbutton">Take photo</button>

            </div>
            <input type="hidden" name="personid" id="personid">
            <input type="hidden" name="passid" id="passid">
            <input type="hidden" name="photo" id="captured_photo">

        </form>
        <div class="alert alert-danger" id="alert" style="display:none;">
            <ul class="list-unstyled" id="myerror">
            </ul>
        </div>
    </div>

    <div id="info">

    </div>


</div>






@endsection

@section('scripts')


<script>
    (() => {
        // The width and height of the captured photo. We will set the
        // width to the value defined here, but the height will be
        // calculated based on the aspect ratio of the input stream.

        const width = 600; // We will scale the photo width to this
        let height = 0; // This will be computed based on the input stream

        // |streaming| indicates whether or not we're currently streaming
        // video from the camera. Obviously, we start at false.

        let streaming = false;

        // The various HTML elements we need to configure or control. These
        // will be set by the startup() function.

        let video = null;
        let canvas = null;
        let photo = null;
        let startbutton = null;

        let localStream = null;

        function startup() {

            video = document.getElementById("video");
            canvas = document.getElementById("canvas");
            photo = document.getElementById("photo");
            startbutton = document.getElementById("startbutton");

            // Media constraints
            const constraints = {
                audio: false,
                video: {
                    //  facingMode: { exact: 'environment' },   // Use the back camera (otherwise the front camera will be used by default)
                    //  width: { ideal: 1024 },
                    //   height: { ideal: 768 }
                }
            };

            navigator.mediaDevices
                .getUserMedia(constraints)
                .then((stream) => {
                    video.srcObject = stream;
                    video.play();
                    localStream = stream;
                })
                .catch((err) => {
                    console.error(`An error occurred: ${err}`);
                });

            video.addEventListener(
                "canplay",
                (ev) => {
                    if (!streaming) {
                        height = video.videoHeight / (video.videoWidth / width);

                        // Firefox currently has a bug where the height can't be read from
                        // the video, so we will make assumptions if this happens.

                        if (isNaN(height)) {
                            height = width / (4 / 3);
                        }

                        video.setAttribute("width", width);
                        video.setAttribute("height", height);
                        canvas.setAttribute("width", width);
                        canvas.setAttribute("height", height);
                        streaming = true;
                    }
                },
                false,
            );

            startbutton.addEventListener(
                "click",
                (ev) => {
                    takepicture();
                   // takePhotoUsingImageCaptureApi();
                    ev.preventDefault();
                },
                false,
            );

            clearphoto();
        }

        // Fill the photo with an indication that none has been
        // captured.

        function clearphoto() {
            const context = canvas.getContext("2d");
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            const data = canvas.toDataURL("image/png");
            photo.setAttribute("src", data);
        }

        // Capture a photo by fetching the current contents of the video
        // and drawing it into a canvas, then converting that to a PNG
        // format data URL. By drawing it on an offscreen canvas and then
        // drawing that to the screen, we can change its size and/or apply
        // other changes before drawing it.

        function takepicture() {
            const context = canvas.getContext("2d");
            if (width && height) {

                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                const data = canvas.toDataURL("image/jpeg");
                photo.setAttribute("src", data);
                document.getElementById("captured_photo").value = data;
            } else {
                clearphoto();
            }
        }

        function takePhotoUsingImageCaptureApi() {

            let src;
            if ("ImageCapture" in window) {
                try {
                    const track = localStream.getVideoTracks()[0];
                    let imageCapture = new ImageCapture(track);
                    imageCapture.takePhoto().then(blob => {
                        const data = URL.createObjectURL(blob);
                        photo.setAttribute("src", data);
                        //convert blob to base64
                        blobToBase64(blob).then(res => {
                            document.getElementById("captured_photo").value = res;
                        console.log(res); // res is base64 now
                        });

                       //
                    });

                    //src = URL.createObjectURL(blob);
                   // photo.setAttribute("src", data);
                } catch (e) {
                    //alert("takePhoto failed: " + e);
                  //  takepicture()
                }
            } else {
                alert("ImageCapture is not supported in this browser");
               // takepicture()
            }


        }
        const blobToBase64 = blob => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            return new Promise(resolve => {
                reader.onloadend = () => {
                resolve(reader.result);
                };
            });
        }

        function stop() {
            try {
                if (localStream) {
                    const tracks = localStream.getTracks();
                    for (let i = 0; i < tracks.length; i++) {
                        const track = tracks[i];
                        track.stop();
                    }
                }
            } catch (e) {
                alert(e.message);
            }
        };

        // Set up our event listener to run the startup process
        // once loading is complete.
        window.addEventListener("load", startup, false);

        document.getElementById("photo").onload = function() {
            let img = document.getElementById("photo");
            document.getElementById("info").innerText = "Image Width: " + img.naturalWidth + ". Image Height: " + img.naturalHeight;
        }




    })();
</script>

<script src="{{ asset('js/country.js') }}"></script>
<script src="{{ asset('js/jquery.form.min.js') }}"></script>
<script>
    var pass_issued = null;

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
        document.getElementById('searchSelfRegDate').valueAsDate = new Date();
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            // let queryName = $('#searchName').val();
            let queryId = $('#searchId').val();
            let queryMob = $('#searchMob').val();
            let querySelfRegDate = $('#searchSelfRegDate').val();
            let querySelfRegNum = $('#searchSelfRegNum').val();

            if (!queryId && !queryMob && !querySelfRegDate && !querySelfRegNum) {
                alert('Please enter at least one search criteria');
                return;
            }
            $.ajax({
                url: "{{ route('admin.self-registrations.search') }}",
                type: 'GET',
                data: {
                    // queryName: queryName,
                    queryId: queryId,
                    queryMob: queryMob,
                    querySelfRegDate: querySelfRegDate,
                    querySelfRegNum: querySelfRegNum
                },
                success: function(data) {
                    let resultsList = $('#resultsList');
                    resultsList.empty();
                    data.forEach(function(item) {
                        if(!item) return;
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
                                            data-person_visitor_passes_count="${item.person_visitor_passes_count}"
                                            data-person_visitor_pass_latest_date="${item.person_visitor_pass_latest?.created_at}"
                                            data-person_visitor_pass_latest_id="${item.person_visitor_pass_latest?.id}"
                                            data-personid="${item.id}"
                                            data-name="${item.name}"
                                            data-age="${item.age}"
                                            data-dob="${item.dob}"
                                            data-gender="${item.gender}"
                                            data-mobile="${item.mobile}"
                                            data-email="${item.email}"
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
            let dob = $(this).data('dob');
            let mobile = $(this).data('mobile')?.toString();
            let email = $(this).data('email');
            let id_type_id = $(this).data('id_type_id');
            let id_detail = $(this).data('id_detail')?.toString();
            let address = $(this).data('address');
            let pincode = $(this).data('pincode')?.toString();

            let person_visitor_passes_count = $(this).data('person_visitor_passes_count') || 0;
            let person_visitor_pass_latest_date = $(this).data('person_visitor_pass_latest_date') || null;
            let person_visitor_pass_latest_id = $(this).data('person_visitor_pass_latest_id') || null;

            if(-1 !== personid){
                $('#personid').val(personid);
            }

            $('#name').val(name);
            $('#mobile').val(mobile);
            $('#dob').val(dob);
            $('#email').val(email);
            $('#gender').val(gender);
            $('#age').val(age);
            $('#id_type_id').val(id_type_id);
            $('#id_detail').val(id_detail);
            $('#address').val(address);
            $('#pincode').val(pincode);
            $('#resultsModal').modal('hide');
            fetchPin(pincode);

            //check if pass is issued to this person
            $('#pass_issed_to_this_person').html('');
          //  alert(person_visitor_passes_count);
            if(person_visitor_passes_count > 0){
                //add a button to view pass details
                let link = "{{ route('admin.visitor-passes.show', ':id') }}";
                link = link.replace(':id', person_visitor_pass_latest_id);

                $('#pass_issed_to_this_person').html(`

                    <div class="mt-1 alert alert-warning">
                         Already issued ${person_visitor_passes_count} pass to this person. Last Pass Date: ${person_visitor_pass_latest_date}
                            <a href="${link}" >View</a>
                    </div>

                `);

            }
        });

        $('#registerForm').ajaxForm({
            beforeSend: function() {
                var percentage = '0';
            },

            beforeSubmit: function(arr, $form, options) {

                $('#alert').hide();
                $('#myerror').empty()
                let valid = true;

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

                $('#spinnerbtn').hide();
                $('#myerror').empty();

                let jsonResponse = JSON.parse(xhr.responseText);
                //alert(jsonResponse);

                //console.log('File has uploaded');
                if (jsonResponse?.errors) {

                    for (const key in jsonResponse.errors) {
                        $('#myerror').append('<li>' + jsonResponse.errors[key] + '</li>');
                    }

                    $('#alert').show();

                } else {
                    $('#alert').hide();
                    // var i = window.location.href.lastIndexOf("/");
                    // window.location = window.location.href.substr(0, i)
                    pass_issued = jsonResponse.pass
                    $('#passid').val(pass_issued.id);
                    $('#personid').val(pass_issued.person_id);
                    $('#register-print-btn').html(`Update and Print (No:${pass_issued.number})`);
                }
            }
        });


    });
</script>

<script>

    //  var visiting_office_instance =  NiceSelect.bind(document.getElementById("visiting_office"), {searchable: true});


    window.onload = function() {
        const selectCountry = document.getElementById("country");
        const visiting_office_category = document.getElementById("visiting_office_category_id");
        const visiting_office_minister = document.getElementById("visiting_office_minister");
        const visiting_office_mla = document.getElementById("visiting_office_mla");

        const visiting_office_input = document.getElementById("visiting_office_input");

        const recommending_office_category = document.getElementById("recommending_office_category_id");
        const recommending_office = document.getElementById("recommending_office");
        const recommending_office_input = document.getElementById("recommending_office_input");

        const date_of_visit = document.getElementById("date_of_visit");
        date_of_visit.value = moment().format("DD.MM.YYYY");

        const selectDistrict = document.getElementById("district");
        const pinCtrl = document.getElementById("pincode");
        const idType = document.getElementById("id_type_id");

        const visitingOfficeSelectMLA = $('#visiting_office_mla');
        const visitingOfficeSelectMinister = $('#visiting_office_minister');
        const recommendingOfficeSelectMLA = $('#recommending_office_mla');
        const recommendingOfficeSelectMinister = $('#recommending_office_minister');


        visitingOfficeSelectMLA.selectpicker('hide');
        visitingOfficeSelectMinister.selectpicker('hide');
        recommendingOfficeSelectMLA.selectpicker('hide');
        recommendingOfficeSelectMinister.selectpicker('hide');

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
            // let office = e.target.value
            let office = visiting_office_category.options[visiting_office_category.selectedIndex].innerHTML;

            visitingOfficeSelectMLA.selectpicker('hide');
            visitingOfficeSelectMinister.selectpicker('hide');
            visiting_office_input.style.display = 'none';
            visiting_office_input.removeAttribute('required');
            if ('MLA' == office) {
                visitingOfficeSelectMLA.selectpicker('show');
            } else if ('Minister' == office) {
                visitingOfficeSelectMinister.selectpicker('show');
            } else {
                visiting_office_input.style.display = 'block';
                visiting_office_input.hidden = false;
                visiting_office_input.setAttribute("required", "");
                visiting_office_input.value = "";
                if (['Legislature Secretary', 'Speaker', 'Deputy Speaker', 'Chief Minister', 'Leader of Opposition'].indexOf(office) !== -1) {
                    let officename = 'O/o ' + office;
                    visiting_office_input.value = officename;
                }
            }

        });


        recommending_office_category.addEventListener("input", function(e) {
            // let office = e.target.value
            let office = recommending_office_category.options[recommending_office_category.selectedIndex].innerHTML;
            recommendingOfficeSelectMLA.selectpicker('hide');
            recommendingOfficeSelectMinister.selectpicker('hide');
            recommending_office_input.style.display = 'none';
            recommending_office_input.removeAttribute('required');
            if ('MLA' == office) {
                recommendingOfficeSelectMLA.selectpicker('show');
            } else if ('Minister' == office) {
                recommendingOfficeSelectMinister.selectpicker('show');
            } else {
                recommending_office_input.style.display = 'block';
                recommending_office_input.hidden = false;
                recommending_office_input.setAttribute("required", "");
                recommending_office_input.value = "";
                if (['Legislature Secretary', 'Speaker', 'Deputy Speaker', 'Chief Minister', 'Leader of Opposition'].indexOf(office) !== -1) {
                    let officename = 'O/o ' + office;
                    recommending_office_input.value = officename;
                }
            }
        });


    };
</script>
@endsection
