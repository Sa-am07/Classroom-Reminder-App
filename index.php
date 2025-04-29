<?php 
session_start();
if(isset($_SESSION['teacher']))
{
    header("location:Teacher/dashboard.php");
}
if(isset($_SESSION['student']))
{
    header("location:Student/dashboard.php");
}
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
            margin: 100px auto 0;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        </style>
    </head>
    <body>
        <!-- Login Page -->
        <main class="container">
            <div class="form-container">
                <h2 class="text-center">Login Account</h2>
                <form action="PHP/login.php" method="post" autocomplete="off" class="form">
                    <div class="mb-3 mt-4">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="1">Teacher</option>
                            <option value="2">Student</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                    <p class="text-center mt-5">Don't have an account? <a href="register.php">Register</a></p>
                </form>
            </div>
        </main>

        <!-- Bootstrap JS and Icons -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-solid fa-eye-slash"></i>';
            });
            if(<?php echo $msg; ?> == 1)
            {
                alert("New Account Registered Successfully...");
            }
            if(<?php echo $msg; ?> == 2)
            {
                alert("Sorry Login Failed Please Try Again...");
            }
        </script>

    </body>
</html>