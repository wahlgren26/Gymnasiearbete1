<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="signup.css">
<link rel="stylesheet" href="form-validation.css">
</head>

NÅGOT FEL MED ATT NÄR DEN BLIR DESELECTED SÅ BLIR DEN STOR OM DEN ÄR INVALID, TA BORT DETTA SEN OSV

<div class="col-sm-12 text-center">
<center>
    <div class="container">
        <form class="form">
            <p class="title">Register </p>
            <p class="message">Sign up now to get started with GymLog</p>
            <div class="flex">
                <label>
                    <input required="" type="text" class="input" pattern="[a-zA-ZåäöÅÄÖ]+" title="Firstname can only contain letters.">
                    <span>Firstname</span>
                </label>
                <label>
                    <input required="" type="text" class="input" pattern="[a-zA-ZåäöÅÄÖ]+" title="Surname can only contain letters.">
                    <span>Surname</span>
                </label>
            </div>
           <label>
               <input required="" type="text" class="input" pattern="[a-zA-Z0-9]+" title="Username can only contain letters and numbers.">
                <span>Username</span>
            </label>
            <label>
                <input required="" type="password" class="input">
                <span>Password</span>
            </label>
            <label>
                <input required="" type="password" class="input">
                <span>Confirm password</span>
            </label>
            <button class="submit">Submit</button>
            <p class="signin">Already have an account? <a href="#">Sign in</a></p>
            <button type="button" class="return-btn" onclick="history.back()">&lt; Return</button>
        </form>
    </div>
</center>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>