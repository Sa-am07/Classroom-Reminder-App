<?php 
session_start();
$_SESSION['teacher'];
$_SESSION['student'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
include "connection.php";
if($role == 1)
{
	$qry = "SELECT * FROM user WHERE Email = '$email' AND Password = '$password' AND Role = 1";
	if(mysqli_num_rows(mysqli_query($con,$qry)) > 0)
	{
		$_SESSION['teacher'] = $email;
		header("location:../Teacher/dashboard.php");
	}
	else 
	{
		session_destroy();
		header("location:../index.php?msg=2");	
	}
}
else 
{
	$qry = "SELECT * FROM user WHERE Email = '$email' AND Password = '$password' AND Role = 2";
	if(mysqli_num_rows(mysqli_query($con,$qry)) > 0)
	{
		$_SESSION['student'] = $email;
		header("location:../Student/dashboard.php");
	}
	else 
	{
		session_destroy();
		header("location:../index.php?msg=2");	
	}
}
?>