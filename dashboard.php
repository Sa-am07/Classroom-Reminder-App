<?php 
session_start();
if(!(isset($_SESSION['teacher'])))
{
	session_destroy();
	header("location:../index.php");
}
$msg = 0;
if(isset($_GET['msg']))
{
	$msg = $_GET['msg'];
}
$email = $_SESSION['teacher'];
include "../PHP/connection.php";
$qry = "SELECT * FROM user WHERE Email = '$email' AND Role = 1";
$res = mysqli_fetch_array(mysqli_query($con,$qry));
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
							<a href="create_reminder.php" class="nav-link">Reminders</a>
						</li>
						<li class="nav-item mt-3 mt-lg-0 ms-lg-5">
							<a href="../PHP/logout.php" class="btn btn-danger">LOGOUT</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- Navbar Section End -->

		<!-- Dashboard Section -->
		<div class="container mt-5">
			<div class="row">
				<div class="col-12 table-responsive">
					<table class="table table-bordered table-hover table-striped text-center">
						<tr>
							<th class="h6">Reminder ID</th>
							<th class="h6">Title</th>
							<th class="h6">Description</th>
							<th class="h6">Due Date</th>
							<th class="h6">Category</th>
							<th class="h6">Assign To</th>
							<th class="h6">Action</th>
						</tr>
						<?php 
						$id = $res['User_ID'];
						$qry = "SELECT * FROM reminder WHERE Created_Teacher = $id";
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
							<td class="align-middle"><?php echo $res['Assign_To']; ?></td>
							<td>
								<a href="edit_reminder.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-warning btn-sm m-1" title="Edit Reminder"><i class="fa-solid fa-pen-to-square"></i></a>
								<a href="../PHP/delete_reminder.php?id=<?php echo $res['Reminder_ID']; ?>" class="btn btn-danger btn-sm m-1" title="Delete Reminder"><i class="fa-solid fa-trash"></i></a>
							</td>
						</tr>
						<?php 
							}
						}
						else 
						{
							echo "<tr><td colspan='7' class='text-center h6'>No Reminder Found</td></tr>";	
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
				alert("New Reminder Created Successfully");
			}
			if(<?php echo $msg; ?> == 2)
			{
				alert("Reminder Edit Successfully");
			}
			if(<?php echo $msg; ?> == 3)
			{
				alert("Reminder Deleted Successfully");
			}
		</script>
		
	</body>
</html>