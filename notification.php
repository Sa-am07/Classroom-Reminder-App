<?php 
session_start();
if(!(isset($_SESSION['student'])))
{
	session_destroy();
	header("location:../index.php");
}
$email = $_SESSION['student'];
include "../PHP/connection.php";
$qry = "SELECT * FROM user WHERE Email = '$email' AND Role = 2";
$res = mysqli_fetch_array(mysqli_query($con,$qry));
$id = $res['User_ID'];
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
							<a href="notification.php" class="nav-link">Notifications</a>
						</li>
						<li class="nav-item mt-3 mt-lg-0 ms-lg-5">
							<a href="../PHP/logout.php" class="btn btn-danger">LOGOUT</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- Navbar Section End -->

		<!-- Notifications Section -->
		<div class="container mt-5">
			<div class="row">
				<?php 
				$qry = "SELECT * FROM reminder WHERE STR_TO_DATE(Due_Date, '%d %b %Y') >= CURDATE() AND TIMESTAMPDIFF(HOUR, NOW(), STR_TO_DATE(due_date, '%d %b %Y')) <= 24 AND Status = 0 ORDER BY Reminder_ID DESC";
				$pro = mysqli_query($con,$qry);
				if(mysqli_num_rows($pro) > 0)
				{
					while($res = mysqli_fetch_array($pro))
					{
						$ids = explode(", ", $res['Assign_To']);
						if(in_array($id, $ids))
						{
				?>
				<div class="col-12 bg-dark text-white mb-3 p-3 pb-0">
					<h6 class="text-primary"><?php echo $res['Title']; ?> | <?php echo $res['Due_Date']; ?></h6>
					<p align="justify" class="m-0 p-0 mt-3"><?php echo $res['Description']; ?></p>
					<p class="text-danger" class="m-0 p-0" style="font-size: 12px;">Teacher Task Reminder</p>
				</div>
				<?php 
						}
					}
				}
				?>
				<?php 
				$qry = "SELECT * FROM personal_reminder WHERE Student_ID = $id AND  STR_TO_DATE(Due_Date, '%d %b %Y') >= CURDATE() AND TIMESTAMPDIFF(HOUR, NOW(), STR_TO_DATE(due_date, '%d %b %Y')) <= 24 AND Status = 0 ORDER BY Reminder_ID DESC";
				$pro = mysqli_query($con,$qry);
				if(mysqli_num_rows($pro) > 0)
				{
					while($res = mysqli_fetch_array($pro))
					{
				?>
				<div class="col-12 bg-dark text-white mb-3 p-3 pb-0">
					<h6 class="text-primary"><?php echo $res['Title']; ?> | <?php echo $res['Due_Date']; ?></h6>
					<p align="justify" class="m-0 p-0 mt-3"><?php echo $res['Description']; ?></p>
					<p class="text-danger" class="m-0 p-0" style="font-size: 12px;">Personal Task Reminder</p>
				</div>
				<?php 
					}
				}
				?>
			</div>
		</div>

		<!-- Bootstrap 5 JS CDN Link -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		
	</body>
</html>