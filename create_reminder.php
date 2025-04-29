<?php 
session_start();
if(!(isset($_SESSION['teacher'])))
{
    session_destroy();
    header("location:../index.php");
}
include "../PHP/connection.php";
$email = $_SESSION['teacher'];
$qry = "SELECT * FROM user WHERE Email = '$email' AND Role = 1";
$res = mysqli_fetch_array(mysqli_query($con,$qry));
$teacherID = $res['User_ID'];
$qry = "SELECT * FROM user WHERE Role = 2";
$pro = mysqli_query($con,$qry);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Virtual Classroom Reminder App</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fontawesome 6 CDN Link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <!-- Custom CSS Link -->
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <style>
        body 
        {
            background-color: #f8f9fa;
        }
        .form-container 
        {
            max-width: 500px;
            margin: 10px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        </style>
    </head>
    <body>

        <!-- Create Reminder Page -->
        <main class="container">
            <div class="form-container">
                <h2 class="text-center">Create Reminder</h2>
                <form action="../PHP/create_reminder.php" method="post" autocomplete="off" class="form">
                    <input type="hidden" name="tid" value="<?php echo $teacherID; ?>" >
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Due Date</label>
                        <input type="date" name="dueDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-select" required>
                            <option value="Assignment">Assignment</option>
                            <option value="Exam">Exam</option>
                            <option value="Event">Event</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Assign To</label>
                        <select name="assignTo[]" class="form-select" multiple size="1" required>
                            <?php 
                            if(mysqli_num_rows($pro) > 0)
                            {
                                while($res = mysqli_fetch_array($pro))
                                {
                                ?>
                                    <option value="<?php echo $res['User_ID']; ?>"><?php echo $res['Name']; ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" disabled id="create">Create</button>
                </form>
                <p class="text-center mt-3">Don't Create Reminder? <a href="dashboard.php">Go Back</a></p>
            </div>
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        const form = document.querySelector('form');
        const create = document.getElementById('create');
        form.addEventListener('input', () => {
        const isValid = form.checkValidity();
        create.disabled = !isValid;
        });
        </script>

    </body>
</html>