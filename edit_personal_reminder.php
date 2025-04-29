<?php 
session_start();
if(!(isset($_SESSION['student'])))
{
    session_destroy();
    header("location:../index.php");
}
include "../PHP/connection.php";
$id = $_GET['id'];
$qry = "SELECT * FROM personal_reminder WHERE Reminder_ID = $id";
$res = mysqli_fetch_array(mysqli_query($con,$qry));
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

        <!-- Edit Reminder Page -->
        <main class="container">
            <div class="form-container">
                <h2 class="text-center">Edit Personal Reminder</h2>
                <form action="../PHP/edit_personal_reminder.php" method="post" autocomplete="off" class="form">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" >
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $res['Title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" required><?php echo $res['Description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Due Date</label>
                        <input type="date" name="dueDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-select" required>
                            <option value="Study Time" <?php if($res['Category'] == "Study Time"){ echo "selected"; } ?> >Study Time</option>
                            <option value="Project Deadline" <?php if($res['Category'] == "Project Deadline"){ echo "selected"; } ?> >Project Deadline</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" disabled id="edit">Edit</button>
                </form>
                <p class="text-center mt-3">Don't Edit Reminder? <a href="personal_reminder.php">Go Back</a></p>
            </div>
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        const form = document.querySelector('form');
        const edit = document.getElementById('edit');
        form.addEventListener('input', () => {
        const isValid = form.checkValidity();
        edit.disabled = !isValid;
        });
        </script>

    </body>
</html>