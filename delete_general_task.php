<?php 
$id = $_GET['id'];
include "connection.php";
$qry = "DELETE FROM reminder WHERE Reminder_ID = $id";
mysqli_query($con,$qry);
header("location:../Student/dashboard.php?msg=2");
?>