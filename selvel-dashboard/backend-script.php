<?php
// Database configuration 
$dbHost     = "localhost";  //  your hostname
$dbUsername = "root";       //  your table username
$dbPassword = "hJ8yW3cP0wV4aW8c";          // your table password
$dbName     = "selvel";  // your database name
 
// Create database connection 
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
//$_POST['country_id']=1;
	
// Fetching state data
		
			
if(isset($_POST['country_id']) && sizeof($_POST['country_id'])>0)
{
	//$snn=$_POST['country_id'];
	//$snn1=$array[]
	foreach ($_POST['country_id'] as $country_id) 
	{
		//echo $country_id[0];
		//print_r($country_id);
		//echo $country_id = implode(',', $_POST['category_id']);
		//$country_id=1;
		if(!empty($country_id))
		{  
			$contryData="SELECT * from slv_category_attribute_list WHERE category_id=$country_id";
			$result=mysqli_query($conn,$contryData);
			if(mysqli_num_rows($result)>0)
			{
				echo "<option value=''>Select Attributes</option>";
				?>
				
					
				
				<?php
				while($arr=mysqli_fetch_assoc($result))
				{
					
				?>
						
											
    
											
											
					
				<?php
					$at_id=$arr['attribute_id'];
					$contryData1="SELECT * from slv_attribute_master WHERE id=$at_id";
					$result1=mysqli_query($conn,$contryData1);
					$arr1=mysqli_fetch_array($result1);
					echo "<option value='".$arr1['id']."'>".$arr1['attribute_name']."</option><br>";
					?>

					
					<?php
				}
				?>
				
				<?php
				
			}  
		}
	}
}
   // Fetching city data
$state_id=!empty($_POST['state_id'])?$_POST['state_id']:'';
if(!empty($state_id))
  {
        $cityData="SELECT * from slv_attribute_features WHERE attribute_id=$state_id";
        $result=mysqli_query($conn,$cityData);
        if(mysqli_num_rows($result)>0)
        {
          echo "<option value=''>Select Features</option>";
          while($arr=mysqli_fetch_assoc($result))
          {
			 ?>
			
			 
				
			 <?php
            echo "<option value='".$arr['id']."'>".$arr['feature']."</option><br>";
        ?>
				
					<?php
          }
        }  
   }
   
         ?>