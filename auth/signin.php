<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="signin.css">
</head>

<body>
<?php
// Starta session om inte startad
session_start();
?>

<div class="col-sm-12 text-center">
<center>
    <div class="container">
        <form class="form" action="signin_handler.php" method="POST">
            <p class="title">Sign In</p>
            <p class="message">Welcome back to GymLog</p>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <label>
                <input required name="username" placeholder="" type="text" class="input" pattern="[a-zA-Z0-9]+" title="Username can only contain letters and numbers">
                <span>Username</span>
            </label>
            
            <label>
                <input required name="password" placeholder="" type="password" class="input">
                <span>Password</span>
            </label>
            
            <button class="submit" type="submit">Sign In</button>
            <p class="signin">Don't have an account? <a href="signup.php">Sign up</a></p>
            <button type="button" class="return-btn" onclick="window.location.href='../';">&lt; Return</button>
        </form>
    </div>
</center>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="signin.js"></script>
</body>
</html> 