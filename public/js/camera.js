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
