<?php 
$id = $_GET['id'];
include "connection.php";
$qry = "DELETE FROM personal_reminder WHERE Reminder_ID = $id";
mysqli_query($con,$qry);
header("location:../Student/personal_reminder.php?msg=3");
?>