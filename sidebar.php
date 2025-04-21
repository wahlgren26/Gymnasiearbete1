<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
            <a href="index.php">GymLog</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="profile.php" class="sidebar-link">
                <i class="lni lni-user"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="day.php" class="sidebar-link">
                <i class="lni lni-calendar"></i>
                <span>Training Schedule</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="workout_log.php" class="sidebar-link">
                <i class="lni lni-timer"></i>
                <span>Workout Log</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
               data-bs-target="#nutrition" aria-expanded="false" aria-controls="nutrition">
                <i class="lni lni-restaurant"></i>
                <span>Nutrition</span>
            </a>
            <ul id="nutrition" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="protein.php" class="sidebar-link">Protein Calculator</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
               data-bs-target="#progress" aria-expanded="false" aria-controls="progress">
                <i class="lni lni-stats-up"></i>
                <span>Goals & Progress</span>
            </a>
            <ul id="progress" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="goal.php" class="sidebar-link">Set Goals</a>
                </li>
                <li class="sidebar-item">
                    <a href="picture.php" class="sidebar-link">Progress Photos</a>
                </li>
                <li class="sidebar-item">
                    <a href="vikt.php" class="sidebar-link">Weight History</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="music.php" class="sidebar-link">
                <i class="lni lni-music"></i>
                <span>Music & Motivation</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="faq.php" class="sidebar-link">
                <i class="lni lni-question-circle"></i>
                <span>FAQ</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <?php
        // Check if user is logged in
        // Session is started in session_handler.php which is included in each page
        if(isset($_SESSION['user_id'])) {
            // User is logged in, show logout
            echo '<a href="auth/logout.php" class="sidebar-link">';
            echo '<i class="lni lni-exit"></i>';
            echo '<span>Logout</span>';
            echo '</a>';
        } else {
            // User is not logged in, show login/register
            echo '<a href="auth/signin.php" class="sidebar-link">';
            echo '<i class="lni lni-enter"></i>';
            echo '<span>Login / Register</span>';
            echo '</a>';
        }
        ?>
    </div>
</aside> 