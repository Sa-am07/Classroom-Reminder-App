<?php 
session_start();
if(!(isset($_SESSION['student'])))
{
	session_destroy();
	header("location:../index.php");
}
$msg = 0;
$count = 0;
if(isset($_GET['msg']))
{
	$msg = $_GET['msg'];
}
$email = $_SESSION['student'];
include "../PHP/connection.php";
$qry = "SELECT * FROM user WHERE Email = '$email' AND Role = 2";
$res = mysqli_fetch_array(mysqli_query($con,$qry));
$id = $res['User_ID'];
$qry = "SELECT * FROM reminder WHERE STR_TO_DATE(Due_Date, '%d %b %Y') >= CURDATE() AND TIMESTAMPDIFF(HOUR, NOW(), STR_TO_DATE(due_date, '%d %b %Y')) <= 24 AND Status = 0 ORDER BY Reminder_ID DESC";
$pro = mysqli_query($con,$qry);
if(mysqli_num_rows($pro) > 0)
{
	$res1 = mysqli_fetch_array($pro);
	$ids = explode(", ", $res1['Assign_To']);
	if(in_array($id, $ids))
	{
		$count++;
	}
}
$qry = "SELECT * FROM personal_reminder WHERE Student_ID = $id AND  STR_TO_DATE(Due_Date, '%d %b %Y') >= CURDATE() AND TIMESTAMPDIFF(HOUR, NOW(), STR_TO_DATE(due_date, '%d %b %Y')) <= 24 AND Status = 0 ORDER BY Reminder_ID DESC";
$count += mysqli_num_rows(mysqli_query($con,$qry));
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Virtual Classroom Reminder App</title>
		<!-- Bootstrap 5 CSS CDN Link -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
		<!-- Fontawesome 6 CDN Link -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
		<!-- Custom CSS Link -->
		<link rel="stylesheet" type="text/css" href="../CSS/style.css">
	</head>
	<body>
		<!-- Navbar Section Start -->
		<nav class="container navbar navbar-expand-lg bg-light navbar-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="dashboard.php">A.O.A, <?php echo $res['Name']; ?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse mt-4 mt-lg-0" id="mynavbar">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item">
							<a href="dashboard.php" class="nav-link">Dashboard</a>
						</li>
						<li class="nav-item">
							<a href="personal_reminder.php" class="nav-link">Personal</a>
						</li>
						<li class="nav-item">
							<a href="notification.php" class="nav-link">Notifications<span class="bg-danger text-white py-1 px-2 rounded ms-1"><?php echo $count; ?></span></a>
						</li>
						<li class="nav-item mt-3 mt-lg-0 ms-lg-5">
							<a href="../PHP/logout.php" class="btn btn-danger">LOGOUT</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- Navbar Section End -->

		<!-- Personal Reminders Section -->
		<div class="container mt-5">
			<div class="row">
				<div class="col-12">
					<a href="create_personal_reminder.php" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Create Personal Reminder</a>
				</div>

				<div class="col-12 table-responsive mt-5">
					<table class="table table-bordered table-hover table-striped text-center">
						<tr>
							<th colspan="6" class="h4 text-white bg-primary">Upcoming Reminders</th>
						</tr>
						<tr>
							<th class="h6">Reminder ID</th>
							<th class="h6">Title</th>
							<th class="h6">Description</th>
							<th class="h6">Due Date</th>
							<th class="h6">Category</th>
							<th class="h6">Action</th>
						</tr>
						<?php 
						$qry = "SELECT * FROM personal_reminder WHERE Student_ID = $id AND STR_TO_DATE(Due_Date, '%d %b %Y') >= CURDATE() AND Status = 0";
						$pro = mysqli_query($con,$qry);
						if(mysqli_num_rows($pro) > 0)
						{
							while($res = mysqli_fetch_array($pro))
							{
						?>
						<tr>
							<td class="align-middle"><?php echo $res['Reminder_ID']; ?></td>
							<td class="align-middle"><?php echo $res['Title']; ?></td>
							<td class="align-middle"><?php echo $res['Description']; ?></td>
							<td class="align-middle"><?php echo $res['Due_Date']; ?></td>
							<td class="align-middle"><?php echo $res['Category']; ?></td>
							<td>
								<a href="../PHP/complete_personal_task.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-success btn-sm m-1" title="Completed Task"><i class="fa-solid fa-circle-check"></i></a>
								<a href="edit_personal_reminder.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-warning btn-sm m-1" title="Edit Task"><i class="fa-solid fa-pen-to-square"></i></a>
								<a href="../PHP/delete_personal_task.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-danger btn-sm m-1" title="Delete Task"><i class="fa-solid fa-trash"></i></a>
							</td>
						</tr>
						<?php
							} 
						}
						else 
						{
							echo "<tr><td colspan='6' class='text-center h6'>No Upcoming Reminders Found</td></tr>";	
						}
						?>
					</table>
				</div>

				<div class="col-12 table-responsive mt-5">
					<table class="table table-bordered table-hover table-striped text-center">
						<tr>
							<th colspan="6" class="h4 text-white bg-success">Completed Reminders</th>
						</tr>
						<tr>
							<th class="h6">Reminder ID</th>
							<th class="h6">Title</th>
							<th class="h6">Description</th>
							<th class="h6">Due Date</th>
							<th class="h6">Category</th>
							<th class="h6">Action</th>
						</tr>
						<?php 
						$qry = "SELECT * FROM personal_reminder WHERE Student_ID = $id AND Status = 1";
						$pro = mysqli_query($con,$qry);
						if(mysqli_num_rows($pro) > 0)
						{
							while($res = mysqli_fetch_array($pro))
							{
						?>
						<tr>
							<td class="align-middle"><?php echo $res['Reminder_ID']; ?></td>
							<td class="align-middle"><?php echo $res['Title']; ?></td>
							<td class="align-middle"><?php echo $res['Description']; ?></td>
							<td class="align-middle"><?php echo $res['Due_Date']; ?></td>
							<td class="align-middle"><?php echo $res['Category']; ?></td>
							<td>
								<a href="../PHP/delete_personal_task.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-danger btn-sm m-1" title="Delete Task"><i class="fa-solid fa-trash"></i></a>
							</td>
						</tr>
						<?php
							} 
						}
						else 
						{
							echo "<tr><td colspan='6' class='text-center h6'>No Completed Reminders Found</td></tr>";	
						}
						?>
					</table>
				</div>

				<div class="col-12 table-responsive mt-5">
					<table class="table table-bordered table-hover table-striped text-center">
						<tr>
							<th colspan="6" class="h4 text-white bg-danger">Overdue Reminders</th>
						</tr>
						<tr>
							<th class="h6">Reminder ID</th>
							<th class="h6">Title</th>
							<th class="h6">Description</th>
							<th class="h6">Due Date</th>
							<th class="h6">Category</th>
							<th class="h6">Action</th>
						</tr>
						<?php 
						$qry = "SELECT * FROM personal_reminder WHERE Student_ID = $id AND STR_TO_DATE(Due_Date, '%d %b %Y') < CURDATE() AND Status = 0";
						$pro = mysqli_query($con,$qry);
						if(mysqli_num_rows($pro) > 0)
						{
							while($res = mysqli_fetch_array($pro))
							{
						?>
						<tr>
							<td class="align-middle"><?php echo $res['Reminder_ID']; ?></td>
							<td class="align-middle"><?php echo $res['Title']; ?></td>
							<td class="align-middle"><?php echo $res['Description']; ?></td>
							<td class="align-middle"><?php echo $res['Due_Date']; ?></td>
							<td class="align-middle"><?php echo $res['Category']; ?></td>
							<td>
								<a href="../PHP/delete_personal_task.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-danger btn-sm m-1" title="Delete Task"><i class="fa-solid fa-trash"></i></a>
							</td>
						</tr>
						<?php
							} 
						}
						else 
						{
							echo "<tr><td colspan='6' class='text-center h6'>No Overdue Reminders Found</td></tr>";	
						}
						?>
					</table>
				</div>
			</div>
		</div>

		<!-- Bootstrap 5 JS CDN Link -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

		<!-- Custom JS -->
		<script>
			if(<?php echo $msg; ?> == 1)
			{
				alert("New Personal Reminder Created Successfully");
			}
			if(<?php echo $msg; ?> == 2)
			{
				alert("Personal Reminder Completed Successfully");
			}
			if(<?php echo $msg; ?> == 3)
			{
				alert("Personal Reminder Deleted Successfully");
			}
			if(<?php echo $msg; ?> == 4)
			{
				alert("Personal Reminder Edit Successfully");
			}
		</script>
		
	</body>
</html>