
<!--Start Back To Top Button-->
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>

<!-- <footer class="footer">
      <div class="container">
        <div class="text-center">
          Copyright © 2018 Rocker Admin
        </div>
      </div>
    </footer> -->
	<!--End footer-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="<?=base_url()?>assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>


   
	
  <!-- simplebar js -->
  <script src="<?=base_url()?>assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?=base_url()?>assets/js/waves.js"></script>
  <!-- sidebar-menu js -->
  <script src="<?=base_url()?>assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?=base_url()?>assets/js/app-script.js"></script>
  
  <!-- Vector map JavaScript -->
  <script src="<?=base_url()?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- Chart js -->
  <script src="<?=base_url()?>assets/plugins/Chart.js/Chart.min.js"></script>
  <!-- Index js -->
  <script src="<?=base_url()?>assets/js/index.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcyqDtmrobvX9IRFIbjbnEslaGPbwvA30&callback=initialize&libraries=places&v=weekly" defer></script>

<!--Data Tables js-->
	<script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  
</body>
<script>

  CKEDITOR.replace( 'faq' );
  CKEDITOR.replace( 'about_us' );
  
  $('#malls').select2(
    { width: '100%', placeholder: "Select an Option", allowClear: true }
    );

$(document).ready(function(){
    $('#msg').delay(5000).slideUp(1000); 
});


     $(document).ready(function() {
      //Default data table
       $('#default-datatable').DataTable();


       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );

    </script>

    <script type="text/javascript">
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            // $('#all_mall + img').remove();
            $('#imgPreview').append('<img src="'+e.target.result+'" width="180" height="120"/>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

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
})

</script>

<script type="text/javascript">
      $(document).ready(function() {
        let initialVal = $(".delivery_status").find("option[selected]").attr('value');
        $(".delivery_status").change(function() {
          if (!confirm("Are you sure?"))
          {     
            $(this).val(initialVal);
          }
          else
          {
            var val = $(this).val();
            var row_id = $(this).parents("tr").attr("data-id");
            var fd = new FormData();
            fd.append('d_status',val);
            fd.append('row_id',row_id);

            $.ajax({
              url : "<?=base_url('restaurant/update_delivery_status')?>",
              method : "POST",
              dataType : 'json',
              data : fd,
              processData: false,
              contentType: false,
              success : function(status){        
              //console.log(status);
              if(status.status == true)
              {
                  alert("Order Update Successfully");
                  // window.location.href="<?=base_url('orders')?>"; 
                  location.reload(); 
              }
              else
              {
                alert("Something Wrong Please Contact to Admin!!  ");
              }
              } 
            });
          }
        });
      });   
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        $(".pickup_status").change(function() {
          // if (!confirm("Are you sure?"))
          // {           
          //   $(this).val($(this).val() == 0 ? 1 : 0);                  
          // }
          // else
          // {
            var val = $(this).val();
            var row_id = $(this).parents("tr").attr("data-id");
            var fd = new FormData();
            fd.append('p_status',val);
            fd.append('row_id',row_id);

            $.ajax({
              url : "<?=base_url('update_pickup_status')?>",
              method : "POST",
              dataType : 'json',
              data : fd,
              processData: false,
              contentType: false,
              success : function(status){        
              //console.log(status);
              if(status.status == true)
              {
                  alert("Pickup Update Successfully");
                  // window.location.href="<?=base_url('orders')?>"; 
                  //location.reload(); 
              }
              else
              {
                alert("Something Wrong Please Contact to Admin!!  ");
              }
              } 
            });
          // }
        });
      });   
    </script>

    <script>
function goBack() {
  window.history.back();
}
</script>
</html>
