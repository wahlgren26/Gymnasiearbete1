<?php
// Include session handler at the very beginning
include 'session_handler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymnasiearbete</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/day.css">
</head>

<body>
    <div class="wrapper">
        <!--start of sidebar-->
        <?php include 'sidebar.php'; ?>
        <!--end of sidebar-->

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Weekly Exercise Schedule</h1>
                    
                    <div class="row g-4">
                        <?php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        $bodyParts = [
                            'Chest', 'Back', 'Legs', 'Shoulders', 'Arms', 'Core', 
                            'Cardio', 'Rest Day', 'Full Body'
                        ];

                        foreach ($days as $day) {
                            $dayLower = strtolower($day);
                            echo '<div class="col-md-6 col-lg-4 mb-4">';
                            echo '<div class="card shadow-lg border-0 rounded-4 h-100" style="transition: transform 0.2s; cursor: pointer;" 
                                  onmouseover="this.style.transform=\'translateY(-5px)\'" 
                                  onmouseout="this.style.transform=\'translateY(0)\'">';
                            
                            echo '<div class="card-body p-4">';
                            echo '<div class="d-flex justify-content-between align-items-center mb-4">';
                            echo '<h3 class="card-title h4 fw-bold mb-0">' . htmlspecialchars($day) . '</h3>';
                            echo '<span class="badge bg-primary rounded-pill">Workout Day</span>';
                            echo '</div>';
                            
                            // Multi-select dropdown with checkboxes
                            echo '<div class="dropdown mb-4">';
                            echo '<button class="form-select form-select-lg border-0 bg-light rounded-3" type="button" 
                                  id="dropdown-' . $dayLower . '" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo 'Choose workout focus';
                            echo '</button>';
                            echo '<ul class="dropdown-menu w-100 p-3 border-0 shadow-lg" aria-labelledby="dropdown-' . $dayLower . '">';
                            foreach ($bodyParts as $part) {
                                echo '<li class="mb-2">';
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" value="' . htmlspecialchars($part) . '" 
                                      id="' . $dayLower . '-' . strtolower(str_replace(' ', '-', $part)) . '">';
                                echo '<label class="form-check-label w-100" for="' . $dayLower . '-' . strtolower(str_replace(' ', '-', $part)) . '">';
                                echo htmlspecialchars($part);
                                echo '</label>';
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '<li class="mt-3">';
                            echo '<button class="btn btn-sm btn-primary w-100" onclick="updateWorkoutFocus(\'' . $dayLower . '\')">Apply Selection</button>';
                            echo '</li>';
                            echo '</ul>';
                            echo '</div>';

                            // Selected body parts display
                            echo '<div id="selected-parts-' . $dayLower . '" class="mb-4">';
                            echo '<div class="d-flex flex-wrap gap-2"></div>';
                            echo '</div>';

                            // Selected exercises display
                            echo '<div id="selected-exercises-' . $dayLower . '" class="mb-4">';
                            echo '<div class="selected-exercises-container"></div>';
                            echo '<button class="btn btn-outline-primary btn-sm mt-3 add-exercise-btn" onclick="showExerciseSelection(\'' . $dayLower . '\')" style="display: none;">';
                            echo '<i class="lni lni-plus me-2"></i>Add Exercise';
                            echo '</button>';
                            echo '</div>';

                            // Exercise selection dropdown (initially hidden)
                            echo '<div id="exercise-dropdowns-' . $dayLower . '" class="mb-4" style="display: none;">';
                            // This will be populated by JavaScript
                            echo '</div>';

                            // Exercise notes textarea
                            echo '<div class="mb-4">';
                            echo '<label for="notes-' . $dayLower . '" class="form-label text-muted small text-uppercase fw-bold">Additional Notes</label>';
                            echo '<textarea class="form-control bg-light border-0 rounded-3" id="notes-' . $dayLower . '" rows="4" 
                                placeholder="Enter additional notes, sets, reps, or weights here..." 
                                style="resize: none;"></textarea>';
                            echo '</div>';

                            // Save button with hover effect
                            echo '<button class="btn btn-primary btn-lg w-100 rounded-3" 
                                  style="transition: all 0.2s;"
                                  onmouseover="this.style.transform=\'scale(1.02)\'" 
                                  onmouseout="this.style.transform=\'scale(1)\'">
                                  <i class="lni lni-save me-2"></i>Save Workout</button>';
                            
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        border: none;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
    }
    
    .btn-primary:hover {
        background: linear-gradient(45deg, #0a58ca, #084298);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
    }
    
    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
    }
    
    .dropdown-menu {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .selected-part {
        background-color: #e7f0ff;
        color: #0d6efd;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .selected-part .remove-part {
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .selected-part .remove-part:hover {
        opacity: 1;
    }

    .exercise-select-container {
        display: flex;
        align-items: start;
        gap: 0.5rem;
    }

    select[multiple] {
        min-height: 100px;
    }

    .form-select option {
        padding: 8px;
        margin: 2px 0;
        border-radius: 4px;
    }

    .form-select option:checked {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        color: white;
    }

    .btn-outline-primary {
        border-color: #0d6efd;
        color: #0d6efd;
        padding: 0.25rem 0.5rem;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        border-color: transparent;
    }

    .selected-exercise-item {
        border: 1px solid rgba(0,0,0,0.1);
        transition: all 0.2s;
    }

    .selected-exercise-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .add-exercise-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .exercise-details input {
        background-color: white;
        border: 1px solid rgba(0,0,0,0.1);
    }

    .exercise-details input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
    }

    .exercise-info {
        color: #0d6efd;
        opacity: 0.7;
        transition: all 0.2s;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .exercise-info:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    .modal-content {
        border-radius: 1rem;
    }

    .modal-header {
        padding: 1.5rem 1.5rem 1rem;
    }

    .modal-body {
        padding: 1rem 1.5rem 1.5rem;
    }

    .exercise-description {
        color: #6c757d;
        font-size: 1rem;
        line-height: 1.6;
    }

    .btn-primary i {
        font-size: 1.2em;
        vertical-align: middle;
    }

    .toast {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        color: white;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
        opacity: 0;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease forwards;
    }

    .toast.show {
        opacity: 1;
    }

    .toast-body {
        padding: 1rem;
        font-weight: 500;
    }

    .motivation-icon {
        font-size: 1.2em;
    }

    .motivation-text {
        font-size: 1rem;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .toast.hide {
        animation: fadeOut 0.3s ease forwards;
    }
    </style>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
    // Updated exercise database with descriptions and links
    const exerciseDatabase = {
        'Chest': [
            {name: 'Bench Press',             desc: 'Compound exercise for chest development',           link: 'https://www.strengthlog.com/bench-press/'},
            {name: 'Incline Bench Press',     desc: 'Targets upper chest muscles',                       link: 'https://www.strengthlog.com/incline-bench-press/'},
            {name: 'Dumbbell Flyes',          desc: 'Isolation movement for chest width',                link: 'https://www.strengthlog.com/dumbbell-chest-fly/'},
            {name: 'Push-Ups',                desc: 'Classic bodyweight chest exercise',                 link: 'https://www.strengthlog.com/push-up/'},
            {name: 'Cable Flyes',             desc: 'Constant tension chest exercise',                   link: 'https://www.strengthlog.com/standing-cable-chest-fly/'},
            {name: 'Decline Bench Press',     desc: 'Targets lower chest region',                        link: 'https://www.strengthlog.com/decline-bench-press/'}
        ],
        'Back': [
            {name: 'Pull-Ups',                desc: 'Upper body compound movement',                      link: 'https://www.strengthlog.com/pull-up/'},
            {name: 'Lat Pulldowns',           desc: 'Machine-based back width builder',                  link: 'https://www.strengthlog.com/lat-pulldown-with-pronated-grip/'},
            {name: 'Barbell Rows',            desc: 'Compound back thickness exercise',                  link: 'https://www.strengthlog.com/barbell-row/'},
            {name: 'Deadlifts',               desc: 'Full body pulling movement',                        link: 'https://www.strengthlog.com/deadlift/'},
            {name: 'Face Pulls',              desc: 'Upper back and rear delt focus',                    link: 'https://www.strengthlog.com/face-pull/'},
            {name: 'Seated Cable Rows',       desc: 'Mid-back thickness builder',                        link: 'https://www.strengthlog.com/seated-cable-row/'}
        ],
        'Legs': [
            {name: 'Squats',                  desc: 'Primary compound leg exercise',                     link: 'https://www.strengthlog.com/squat/'},
            {name: 'Deadlifts',               desc: 'Full body pulling exercise for posterior chain',    link: 'https://www.strengthlog.com/deadlift/'},
            {name: 'Leg Press',               desc: 'Machine-based quad-dominant movement',               link: 'https://www.strengthlog.com/leg-press/'},
            {name: 'Lunges',                  desc: 'Unilateral lower body exercise',                    link: 'https://www.strengthlog.com/dumbbell-lunge/'},
            {name: 'Leg Extensions',          desc: 'Isolation exercise for quadriceps',                 link: 'https://www.strengthlog.com/leg-extension/'},
            {name: 'Calf Raises',             desc: 'Isolation exercise for calf muscles',               link: 'https://www.strengthlog.com/standing-calf-raise/'}
        ],
        'Shoulders': [
            {name: 'Military Press',          desc: 'Compound overhead pressing movement',                link: 'https://www.strengthlog.com/overhead-press/'},
            {name: 'Lateral Raises',          desc: 'Isolation exercise for lateral deltoids',           link: 'https://www.strengthlog.com/lateral-raises/'},
            {name: 'Front Raises',            desc: 'Isolation exercise for front deltoids',             link: 'https://www.strengthlog.com/front-raise/'},
            {name: 'Face Pulls',              desc: 'Upper back and rear delt exercise',                 link: 'https://www.strengthlog.com/face-pull/'},
            {name: 'Upright Rows',            desc: 'Compound exercise for traps and delts',             link: 'https://www.strengthlog.com/upright-row/'},
            {name: 'Arnold Press',            desc: 'Variation of shoulder press for full deltoid development', link: 'https://www.strengthlog.com/arnold-press/'}
        ],
        'Arms': [
            {name: 'Bicep Curls',             desc: 'Isolation exercise for biceps',                     link: 'https://www.strengthlog.com/barbell-curl/'},
            {name: 'Tricep Extensions',       desc: 'Isolation exercise for triceps',                    link: 'https://www.strengthlog.com/triceps-pushdown/'},
            {name: 'Hammer Curls',            desc: 'Bicep exercise that also targets forearms',          link: 'https://www.strengthlog.com/hammer-curl/'},
            {name: 'Skull Crushers',          desc: 'Lying tricep extension exercise',                   link: 'https://www.strengthlog.com/skull-crusher/'},
            {name: 'Preacher Curls',          desc: 'Bicep isolation with limited shoulder movement',    link: 'https://www.strengthlog.com/preacher-curl/'},
            {name: 'Diamond Push-Ups',        desc: 'Bodyweight tricep-focused exercise',                link: 'https://www.strengthlog.com/close-grip-push-up/'}
        ],
        'Core': [
            {name: 'Planks',                  desc: 'Isometric core strengthening exercise',             link: 'https://www.strengthlog.com/plank/'},
            {name: 'Crunches',                desc: 'Basic abdominal exercise',                          link: 'https://www.strengthlog.com/crunch/'},
            {name: 'Leg Raises',              desc: 'Lower abdominal focused movement',                  link: 'https://www.strengthlog.com/leg-raises/'},
            {name: 'Russian Twists',          desc: 'Rotational exercise for obliques',                  link: 'https://www.strengthlog.com/russian-twist/'},
            {name: 'Ab Wheel Rollouts',       desc: 'Advanced core stability exercise',                  link: 'https://www.strengthlog.com/ab-wheel-rollout/'},
            {name: 'Dead Bug',                desc: 'Core stability exercise with limb movement',        link: 'https://www.strengthlog.com/dead-bug/'}
        ],
        'Cardio': [
            {name: 'Running',                 desc: 'Classic cardiovascular exercise',                   link: 'https://www.strengthlog.com/exercises-for-running-faster/'},
            {name: 'Cycling',                 desc: 'Low-impact cardiovascular exercise',                link: 'https://www.webmd.com/fitness-exercise/biking-workout'},
            {name: 'Jump Rope',               desc: 'High intensity cardio and coordination exercise',   link: 'https://www.strengthlog.com/jump-rope/'},
            {name: 'HIIT',                    desc: 'High-Intensity Interval Training for efficient cardio', link: 'https://www.webmd.com/fitness-exercise/high-intensity-interval-training-hiit'},
            {name: 'Swimming',                desc: 'Full body, low-impact cardio exercise',             link: 'https://www.strengthlog.com/strength-training-for-swimmers/'},
            {name: 'Rowing',                  desc: 'Full-body cardio and strength exercise',            link: 'https://www.strengthlog.com/rowing-machine/'}
        ],
        'Full Body': [
            {name: 'Burpees',                 desc: 'High-intensity full body exercise',                 link: 'https://www.strengthlog.com/burpees/'},
            {name: 'Mountain Climbers',       desc: 'Dynamic core and cardio exercise',                  link: 'https://www.strengthlog.com/mountain-climbers/'},
            {name: 'Turkish Get-Ups',         desc: 'Complex full body stability exercise',             link: 'https://www.strengthlog.com/turkish-get-up/'},
            {name: 'Thrusters',               desc: 'Compound exercise combining squat and press',        link: 'https://www.strengthlog.com/thrusters/'},
            {name: 'Clean and Press',         desc: 'Olympic lifting movement for power and strength',    link: 'https://www.strengthlog.com/clean-and-press/'}
        ],
        'Rest Day': []
    };


    function updateWorkoutFocus(day) {
        const checkboxes = document.querySelectorAll(`input[id^="${day}-"]:checked`);
        const selectedPartsContainer = document.querySelector(`#selected-parts-${day} .d-flex`);
        const exerciseDropdownsContainer = document.querySelector(`#exercise-dropdowns-${day}`);
        const addExerciseBtn = document.querySelector(`#selected-exercises-${day} .add-exercise-btn`);
        
        selectedPartsContainer.innerHTML = '';
        exerciseDropdownsContainer.innerHTML = '';
        
        if (checkboxes.length > 0) {
            exerciseDropdownsContainer.style.display = 'block';
            addExerciseBtn.style.display = 'inline-flex';
        }
        
        checkboxes.forEach(checkbox => {
            const part = checkbox.value;
            // Add selected part tag
            const partElement = document.createElement('div');
            partElement.className = 'selected-part';
            partElement.innerHTML = `
                ${part}
                <span class="remove-part" onclick="removePart('${day}', '${part}')">×</span>
            `;
            selectedPartsContainer.appendChild(partElement);

            // Add exercise dropdown for this body part
            if (exerciseDatabase[part] && exerciseDatabase[part].length > 0) {
                const dropdownContainer = document.createElement('div');
                dropdownContainer.className = 'mb-3';
                dropdownContainer.innerHTML = `
                    <label class="form-label text-muted small text-uppercase fw-bold">${part} Exercises</label>
                    <div class="exercise-select-container">
                        <select class="form-select form-select-sm border-0 bg-light rounded-3" 
                                id="exercises-${day}-${part.toLowerCase().replace(' ', '-')}"
                                data-body-part="${part}"
                                onchange="addSelectedExercise('${day}', '${part}', this)">
                            <option value="">Select an exercise</option>
                            ${exerciseDatabase[part].map(exercise => 
                                typeof exercise === 'object' ? 
                                `<option value="${exercise.name}" 
                                        data-desc="${exercise.desc || ''}"
                                        data-link="${exercise.link || '#'}">
                                    ${exercise.name}
                                </option>` :
                                `<option value="${exercise}">${exercise}</option>`
                            ).join('')}
                        </select>
                        <button class="btn btn-sm btn-outline-primary ms-2" 
                                onclick="addCustomExercise('${day}', '${part}')">
                            <i class="lni lni-plus"></i>
                        </button>
                    </div>
                `;
                exerciseDropdownsContainer.appendChild(dropdownContainer);
            }
        });
    }

    function addSelectedExercise(day, bodyPart, selectElement) {
        const exerciseName = selectElement.value;
        if (!exerciseName) return;
        
        // Get the selected option
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const exerciseDesc = selectedOption.getAttribute('data-desc') || '';
        const exerciseLink = selectedOption.getAttribute('data-link') || '#';
        
        // Create exercise element
        addExerciseToDay(day, bodyPart, exerciseName, exerciseDesc, exerciseLink);
        
        // Reset select
        selectElement.value = "";
    }

    function addCustomExercise(day, bodyPart) {
        const exerciseName = prompt("Enter exercise name:");
        if (!exerciseName) return;
        
        const exerciseDesc = prompt("Enter exercise description (optional):", "");
        const exerciseLink = prompt("Enter exercise link (optional):", "#");
        
        addExerciseToDay(day, bodyPart, exerciseName, exerciseDesc, exerciseLink);
    }

    function showExerciseSelection(day) {
        document.querySelector(`#exercise-dropdowns-${day}`).style.display = 'block';
    }

    function removeExercise(button) {
        const exerciseItem = button.closest('.selected-exercise-item');
        if (exerciseItem) {
            exerciseItem.remove();
        }
    }

    function removePart(day, part) {
        const checkbox = document.getElementById(`${day}-${part.toLowerCase().replace(' ', '-')}`);
        if (checkbox) {
            checkbox.checked = false;
            updateWorkoutFocus(day);
        }
    }

    function addExerciseToDay(day, bodyPart, exerciseName, exerciseDesc, exerciseLink) {
        const selectedExercisesContainer = document.querySelector(`#selected-exercises-${day} .selected-exercises-container`);
        const exerciseElement = document.createElement('div');
        exerciseElement.className = 'selected-exercise-item mb-3 p-3 bg-light rounded-3';
        exerciseElement.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="mb-0 fw-bold">${exerciseName}</h6>
                    <button class="btn btn-link p-0 exercise-info" 
                            onclick="showExerciseInfo('${exerciseName}', '${exerciseDesc}', '${exerciseLink}')">
                        <i class="lni lni-information"></i>
                    </button>
                </div>
                <button class="btn btn-sm btn-link text-danger p-0" 
                        onclick="removeExercise(this)">
                    <i class="lni lni-close"></i>
                </button>
            </div>
            <div class="exercise-details">
                <div class="row g-2">
                    <div class="col">
                        <input type="text" class="form-control form-control-sm" placeholder="Sets">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm" placeholder="Reps">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm" placeholder="Weight">
                    </div>
                </div>
            </div>
        `;
        selectedExercisesContainer.appendChild(exerciseElement);
        
        // Hide exercise dropdowns and show add button
        document.querySelector(`#exercise-dropdowns-${day}`).style.display = 'none';
        document.querySelector(`#selected-exercises-${day} .add-exercise-btn`).style.display = 'inline-flex';
    }

    function showExerciseInfo(name, description, link) {
        const modal = new bootstrap.Modal(document.getElementById('exerciseInfoModal'));
        document.getElementById('exerciseInfoTitle').textContent = name;
        
        let modalBody = document.getElementById('exerciseInfoBody');
        modalBody.innerHTML = '';
        
        if (description) {
            const descElement = document.createElement('p');
            descElement.className = 'exercise-description';
            descElement.textContent = description;
            modalBody.appendChild(descElement);
        }
        
        if (link && link !== '#') {
            const linkElement = document.createElement('a');
            linkElement.href = link;
            linkElement.target = '_blank';
            linkElement.textContent = 'Learn more about this exercise on StrengthLog';
            linkElement.className = 'btn btn-sm btn-primary mt-2';
            modalBody.appendChild(linkElement);
        }
        
        modal.show();
    }

    // Add these new functions and arrays for motivational popups
    const motivationalMessages = [
        "You're crushing it! 💪",
        "One more rep! You got this! 🔥",
        "Every rep counts! Keep pushing! ⚡",
        "Making progress every day! 📈",
        "Stay strong, stay focused! 🎯",
        "You're stronger than you think! 💫",
        "Small steps, big results! 🌟",
        "Your future self will thank you! 🙏",
        "Keep showing up! 🚀",
        "You're doing amazing! ⭐"
    ];

    function showMotivationalPopup() {
        // Create toast container if it doesn't exist
        if (!document.getElementById('toastContainer')) {
            const container = document.createElement('div');
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            container.id = 'toastContainer';
            document.body.appendChild(container);
        }

        // Create and show toast
        const toastId = 'toast-' + Date.now();
        const message = motivationalMessages[Math.floor(Math.random() * motivationalMessages.length)];
        
        const toastElement = document.createElement('div');
        toastElement.className = 'toast';
        toastElement.id = toastId;
        toastElement.innerHTML = `
            <div class="toast-body d-flex align-items-center">
                <span class="motivation-icon me-2">✨</span>
                <span class="motivation-text">${message}</span>
            </div>
        `;
        
        document.getElementById('toastContainer').appendChild(toastElement);
        
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        toast.show();

        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function () {
            toastElement.remove();
        });
    }

    function scheduleRandomMotivation() {
        // Show first message after 30-120 seconds
        setTimeout(() => {
            showMotivationalPopup();
            // Then schedule next messages every 60-180 seconds
            setInterval(showMotivationalPopup, Math.random() * (180000 - 60000) + 60000);
        }, Math.random() * (120000 - 30000) + 30000);
    }

    // Start scheduling motivational messages when page loads
    scheduleRandomMotivation();
    </script>

    <!-- Exercise Info Modal -->
    <div class="modal fade" id="exerciseInfoModal" tabindex="-1" aria-labelledby="exerciseInfoTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exerciseInfoTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="exerciseInfoBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
