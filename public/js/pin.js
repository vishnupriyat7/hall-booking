function fetchPin(pin) {

    // Creating Our XMLHttpRequest object
    let xhr = new XMLHttpRequest();
    //let pin = e.target.value
    if (pin.length != 6) {
        //alert("Pincode should be 6 digits" + pin.length + " " + pin);
        return;
    }

    $('#post_office_select').hide();
    $('#post_office').show();
    $('#post_office').val('');
    $('#district').val('');
    $('#state').val('');
    $('#post_office_select').html('');
    $("#post_office").prop('required',true);
    $('#post_office_select').prop('required',false);
    // Making our connection
    //let url = 'https://api.postalpincode.in/pincode/' + pin;
    let url = '/api/pindetails/' + pin;
    xhr.open("GET", url, true);

    // function execute after request is successful
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            let data = JSON.parse(this.responseText).pincodeDetails;
            if (data.length )
            {
                $('#post_office_select').removeAttr('hidden');
                $('#post_office_select').show();
                $('#post_office').hide();
                $("#post_office_select").prop('required',true);
                $('#post_office').prop('required',false);
                $.each(data, function (index, value) {
                   $("#post_office_select").append('<option value="'+value.post_office_name +'">'+value.post_office_name+'</option>');
                });

                let postOffice = data[0];
                document.getElementById("district").value = postOffice.district_name;
                document.getElementById("state").value = postOffice.state.state_name;
            }
        }
    }
    // Sending our request
    xhr.send();
}
