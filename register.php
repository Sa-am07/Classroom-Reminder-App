<?php 
$msg = 0;
if(isset($_GET['msg']))
{
    $msg = $_GET['msg'];
}
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
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        </style>
    </head>
    <body>

        <!-- Registration Page -->
        <main class="container">
            <div class="form-container">
                <h2 class="text-center">Create Your Account</h2>
                <form action="PHP/registration.php" method="post" autocomplete="off" class="form">
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="1">Teacher</option>
                            <option value="2">Student</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" disabled id="signUpBtn">Sign Up</button>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="index.php">Log In</a></p>
            </div>
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        const form = document.querySelector('form');
        const signUpBtn = document.getElementById('signUpBtn');
        form.addEventListener('input', () => {
        const isValid = form.checkValidity();
        signUpBtn.disabled = !isValid;
        });
        if(<?php echo $msg; ?> == 1)
        {
            alert("Sorry Email Already Exist...");
        }
        </script>

    </body>
</html>