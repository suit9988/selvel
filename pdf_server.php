<?php
$con = mysqli_connect("localhost", "root", "hJ8yW3cP0wV4aW8c", "selvel")Or die("DB not Connected");
$date=date('d-m-Y h:i:s');
$qry=mysqli_query($con,"INSERT INTO slv_catelogue (name, email, contact,  created) values ('".$_POST['name']."','".$_POST['email']."','".$_POST['contact']."','$date')");

header("Content-disposition: attachment; filename=dummy.pdf");
header("Content-type: application/pdf");
readfile("dummy.pdf");
?>