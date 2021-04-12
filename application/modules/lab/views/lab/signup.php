
<body>
 <div id="wrapper">
	<div class="card border-primary border-top-sm border-bottom-sm card-authentication1 mx-auto my-5 animated bounceInDown">
		<div class="card-body">
		 <div class="card-content p-2">
		  <div class="card-title text-uppercase text-center pb-2">SignUp Restaurant</div>		    
		    <form method="POST" action="<?=base_url('restaurant/signup')?>" enctype="multipart/form-data">
			  <div class="form-group">
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Name*</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" id="" value="<?=set_value('name')?>" name="name" placeholder="Name">
								<?=form_error('name')?>
								</div>
						</div>		
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Last Name*</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" id="" value="<?=set_value('l_name')?>" name="l_name" placeholder="Last Name">
								<?=form_error('l_name')?>
								</div>
						</div>	
					</div>
			  </div>
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Mobile Number*</label>
								<div class="col-sm-9">
									<input id="country_code" name="country_code" type="hidden" class="form-control">
									<input id="country" name="mobile_number" value="<?=set_value('mobile_number')?>" type="tel" class="form-control">
									<?=form_error('mobile_number')?>
								</div>
						</div>			
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Email Address*</label>
								<div class="col-sm-9">									
									<input name="email" value="<?=set_value('email')?>" placeholder="Email" type="text" class="form-control">
									<?=form_error('email')?>
								</div>
						</div>			
					</div>					
			  </div>
			  <div class="row">
			  <div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Restaurant Name*</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" value="<?=set_value('restaurant_name')?>" name="restaurant_name" placeholder="Restaurant Name">
								<?=form_error('restaurant_name')?>
								</div>
						</div>					
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Address</label>
								<div class="col-sm-9">
								<input type="text" id="address-input" class="map-input form-control pac-target-input" name="street_address" 
								value="<?=set_value('street_address')?>" placeholder="Address">	
								<?=form_error('street_address')?>
								</div>
								<div class="col-sm-3">
                                    <input type="hidden" class="form-control manual-address-input" readonly name="longitude" id="address-langitude" placeholder="Longitude">
                                  </div>
                                    <div class="col-sm-3">
                                        <input type="hidden" class="form-control manual-address-input" readonly name="latitude" id="address-latitude" placeholder="Latitude">
                                  </div>
								  <div id="address-map"></div>
						</div>
					</div>					
			  </div>
			  <div class="row">			  
			  <div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Locality</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" name="street_address2" value="<?=set_value('street_address2')?>" placeholder="Locality">	
								</div>
						</div>
					</div>	
			  <div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">City</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" name="city" value="<?=set_value('city')?>" placeholder="City">
								<?=form_error('city')?>
								</div>
						</div>
					</div>				
			  </div>
			  <div class="row">			  
			  <div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Country</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" name="country" value="<?=set_value('country')?>" placeholder="Country">	
								<?=form_error('country')?>
								</div>
						</div>
					</div>	
			  <div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Estimated Delivery time</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" name="estimated_delivery_time" value="<?=set_value('estimated_delivery_time')?>" placeholder="Estimated Delivery time">	
								<?=form_error('estimated_delivery_time')?>
								</div>
						</div>
					</div>				
			  </div>
			  <div class="row">			  
			  <div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Restaurant Open timings</label>
								<div class="col-sm-9">
								<input type="time" class="form-control" name="restaurant_open_timings" value="<?=set_value('restaurant_open_timings')?>" placeholder="Restaurant Open timings">	
								<?=form_error('restaurant_open_timings')?>
								</div>
						</div>
				</div>	
				<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Restaurant Close timings</label>
								<div class="col-sm-9">
								<input type="time" class="form-control" name="restaurant_close_timings" value="<?=set_value('restaurant_close_timings')?>" placeholder="Restaurant Close timings">	
								<?=form_error('restaurant_close_timings')?>
								</div>
						</div>
				</div>					
			  </div>
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Upload ID Proof*</label>
								<div class="col-sm-9">
									<input id="country" name="id_proof" type="file" class="form-control">
									<?=form_error('id_proof')?>
								</div>
						</div>			
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Upload Restaurant License*</label>
								<div class="col-sm-9">
								<input type="file" class="form-control" value="<?=set_value('restaurant_license')?>" name="restaurant_license" placeholder="restaurant Name">
								<?=form_error('restaurant_license')?>
								</div>
						</div>					
					</div>
			  </div>
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Restaurant Image*</label>
								<div class="col-sm-9">
									<input id="country" name="restaurant_img" type="file" class="form-control">
									<?=form_error('restaurant_img')?>
								</div>
						</div>			
					</div>
					<div class="col-md-6">
										
					</div>
			  </div>
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Account Holder Name*</label>
								<div class="col-sm-9">
									<input id="country" name="account_holder_name" value="<?=set_value('account_holder_name')?>" type="text" class="form-control" placeholder="Account Holder Name">
									<?=form_error('account_holder_name')?>
								</div>
						</div>						
										
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Bank Code*</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" value="<?=set_value('bank_code')?>" name="bank_code" placeholder="Bank Code">
								<?=form_error('bank_code')?>
								</div>
						</div>					
					</div>
			  </div>
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Account Number*</label>
								<div class="col-sm-9">
									<input id="country" name="account_number" value="<?=set_value('account_number')?>" type="text" class="form-control" placeholder="Account Number">
									<?=form_error('account_number')?>
								</div>
						</div>						
										
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Confirm Account Number*</label>
								<div class="col-sm-9">
								<input type="text" class="form-control" value="<?=set_value('c_account_number')?>" name="c_account_number" placeholder="Confirm Account Number">
								<?=form_error('c_account_number')?>
								</div>
						</div>					
					</div>
			  </div>
			  <div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Password*</label>
								<div class="col-sm-9">
									<input id="country" name="password" value="<?=set_value('password')?>" type="password" class="form-control" placeholder="Password">
									<?=form_error('password')?>
								</div>
						</div>						
										
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Re-enter password*</label>
								<div class="col-sm-9">
								<input type="password" class="form-control" value="<?=set_value('re_password')?>" name="re_password" placeholder="Re-enter password*">
								<?=form_error('re_password')?>
								</div>
						</div>					
					</div>
			  </div>
			  <div class="row">
					<div class="col-md-6">	
					<div class="form-group row">
						<input type="checkbox" id="vehicle2" name="condition" <?=!empty(set_value('condition'))?'checked':''?>>
  						<label for="vehicle2">Agree to terms and conditions</label><br>
						<?=form_error('condition')?>
					</div>				
					</div>				
			  </div>			 
			  </div>			  
			  <button type="submit" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light mt-3">Sign up</button>
			  <div class="text-center pt-3">
				<hr>
				<p class="text-muted">Return to the <a href="<?=base_url('restaurant/login')?>"> Sign In</a></p>
			  </div>
			 </form>
		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	</div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>

	
</body>
<style>
	.card-authentication1 {
    max-width: 86rem;
}

.intl-tel-input {
    position: relative;
    display: block;
	margin-top: 10px;
}
.form-control-rounded
{
	margin-top: 10px;
}

.col-form-label {
    font-size: 11px;
}

.form-group.row p {
    color: red;
}
	</style>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$setting->google_api?>&callback=initialize&libraries=places&v=weekly" defer></script>

	<script>

		$("#country").intlTelInput({
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
});

		$("#country").on("countrychange", function(){
			var getCode = $("#country").intlTelInput('getSelectedCountryData').dialCode;
			$('#country_code').val(getCode);
			//console.log(getCode);
		});

		function initialize() {
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    const locationInputs = document.getElementsByClassName("map-input");
    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    for (let i = 0; i < locationInputs.length; i++) {
        const input = locationInputs[i];
        console.log(input);
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-langitude").value != '';
        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
        const langitude = parseFloat(document.getElementById(fieldKey + "-langitude").value) || 151.2195;
        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {lat: latitude, lng: langitude},
            zoom: 13
        });
        const marker = new google.maps.Marker({
            map: map,
            position: {lat: latitude, lng: langitude},
        });
        marker.setVisible(isEdit);
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
    }
    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(false);
            const place = autocomplete.getPlace();
            geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng);
                }
            });
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });
    }
}


function setLocationCoordinates(key, lat, lng) {
    const latitudeField = document.getElementById(key + "-" + "latitude");
    const langitudeField = document.getElementById(key + "-" + "langitude");
    latitudeField.value = lat;
    langitudeField.value = lng;
    $('.manual-address-input').attr("readonly", true);
}

$("#address-input").on("keyup", function() {
    if ($(this).val().length == 0)
    {
        $('.manual-address-input').val("");
        $('.manual-address-input').attr("readonly", false);
    }
});


		</script>
</html>
