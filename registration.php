<?php 
$id = 1;
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
include "connection.php";
$qry = "SELECT * FROM user WHERE Email = '$email' AND Role = $role";
if(mysqli_num_rows(mysqli_query($con,$qry)) == 0)
{
	$qry = "SELECT * FROM user ORDER BY User_ID DESC LIMIT 1";
	if(mysqli_num_rows(mysqli_query($con,$qry)) > 0)
	{
		$res = mysqli_fetch_array(mysqli_query($con,$qry));
		$id = $res['User_ID'] + 1;
	}
	$qry = "INSERT INTO user VALUES ($id, '$name', '$email', '$password', $role)";
	mysqli_query($con,$qry);
	header("location:../index.php?msg=1");
}
else 
{
	header("location:../register.php?msg=1");	
}
?>