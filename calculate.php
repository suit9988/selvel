<?php

	include_once 'include/functions.php';
	$functions = new Functions(); 
if($_POST['number']==null){
echo "Please Enter a Number";
}else {
if (!is_numeric($_POST['number'])) {
echo "Please enter only numbers";
}else{
echo "Square Root of " .$_POST['number'] ." is ".sqrt($_POST['number']);
}
}




                          $reward_pt=$_GET['point'];
                          //$user_id=$loggedInUserDetailsArr['id'];
                          $user_id=105;
                          
                            $qry_check_point = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."customers WHERE id='".$user_id."'"));
                            $current_point=$qry_check_point['reward_point'];
                            $current_point1=$current_point-$reward_pt;
                            //exit();
                            if($reward_pt<=$current_point){
                              //echo "hiii";
                              $qry_check_points1 = "insert into pp_loyalty_points (cust_id,before_reward_points,debit,current_reward_point)values('$user_id','$current_point','$reward_pt','$current_point1')"; 
                              $qry_check_points2 = $functions->query($qry_check_points1);
                                $qry_check_points3 = $functions->fetch($qry_check_points2);
                            

                            }
                            
                         
                          echo $finalTotal-$reward_pt;
?>