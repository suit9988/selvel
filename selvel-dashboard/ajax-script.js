// ajax script for getting state data
   $(document).on('change','#category', function(){
      var countryID = $(this).val();
	 // alert(countryID);
      if(countryID){
          $.ajax({
              type:'POST',
              url:'backend-script.php',
              data:{'country_id':countryID},
              success:function(result){
                  $('#state').html(result);
                 
              }
          }); 
      }else{
          $('#state').html('<option value="">Attribute</option>');
          $('#city').html('<option value=""> Features </option>'); 
      }
  });
    // ajax script for getting  city data
   $(document).on('change','#state', function(){
      var stateID = $(this).val();
      if(stateID){
          $.ajax({
              type:'POST',
              url:'backend-script.php',
              data:{'state_id':stateID},
              success:function(result){
                  $('#city').html(result);
                 
              }
          }); 
      }else{
          $('#city').html('<option value="">Features</option>');
          
      }
  });