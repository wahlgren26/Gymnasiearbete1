<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
</head>

<body>
<?php
// Starta session om inte startad
session_start();
?>

<div class="col-sm-12 text-center">
<center>
    <div class="container">
        <form class="form" action="signup_handler.php" method="POST">
            <p class="title">Register </p>
            <p class="message">Sign up now to get started with GymLog</p>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="flex">
                <label>
                    <input required name="firstname" placeholder="" type="text" class="input" pattern="[a-zA-ZåäöÅÄÖ]+" title="Firstname can only contain letters.">
                    <span>Firstname</span>
                </label>
                <label>
                    <input required name="lastname" placeholder="" type="text" class="input" pattern="[a-zA-ZåäöÅÄÖ\s]+" title="Surname can only contain letters and spaces.">
                    <span>Surname</span>
                </label>
            </div>
            <label>
                <input required name="username" placeholder="" type="text" class="input" pattern="[a-zA-Z0-9]+" title="Username can only contain letters and numbers.">
                <span>Username</span>
            </label>
            <label>
                <input required name="email" placeholder="" type="email" class="input">
                <span>Email</span>
            </label>
            <label>
                <input required name="password" placeholder="" type="password" class="input" 
                    pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
                    title="Password must contain at least 8 characters, one letter, one number and one special character">
                <span>Password</span>
            </label>
            <label>
                <input required name="confirm_password" placeholder="" type="password" class="input">
                <span>Confirm password</span>
            </label>
            <button class="submit" type="submit">Submit</button>
            <p class="signin">Already have an account? <a href="signin.php">Sign in</a></p>
            <button type="button" class="return-btn" onclick="window.location.href='../';">&lt; Return</button>
        </form>
    </div>
</center>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="signup.js"></script>
</body>
</html>