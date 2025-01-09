<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymnasiearbete</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="sidebarstyle.css">
</head>

<body>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="#">GymLog</a>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-dumbbell"></i>
                    <span>Exercise database</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-calendar"></i>
                    <span>Schedules</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                   data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-bar-chart"></i>
                    <span>Goals & Progress</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Choose Goals</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Progress Pictures</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Weight Notes</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-music"></i>
                    <span>Music & Motivation</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-question-circle"></i>
                    <span>FAQ</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link">
                <i class="lni lni-enter"></i>
                <span>Login / Register</span>
            </a>
        </div>
    </aside>
    <div class="main p-3">
        <div class="text-center">
            <h1>
                Sidebar Bootstrap 5
            </h1>

            <form action="" method="GET">
                <label for="fornamn">Förnamn:</label><br>
                <input type="text" id="fornamn" name="fornamn"><br><br>

                <label for="efternamn">Efternamn:</label><br>
                <input type="text" id="efternamn" name="efternamn"><br><br>

                <label for="num1">Nummer 1:</label><br>
                <input type="number" id="num1" name="num1"><br><br>

                <label for="num2">Nummer 2:</label><br>
                <input type="number" id="num2" name="num2"><br><br>

                <label for="num3">Nummer 3:</label><br>
                <input type="number" id="num3" name="num3"><br><br>

                <input type="submit" value="Testa">
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>