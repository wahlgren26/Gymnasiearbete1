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
    // Populate the modal with day and body part
    document.getElementById('customExerciseDay').value = day;
    document.getElementById('customExerciseBodyPart').value = bodyPart;

    // Reset form fields
    document.getElementById('customExerciseName').value = '';
    document.getElementById('customExerciseDescription').value = '';
    document.getElementById('customExerciseLink').value = '';

    // Show the modal
    const customExerciseModal = new bootstrap.Modal(document.getElementById('customExerciseModal'));
    customExerciseModal.show();
}

// Handle save button click for custom exercise
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveCustomExercise').addEventListener('click', function() {
        const day = document.getElementById('customExerciseDay').value;
        const bodyPart = document.getElementById('customExerciseBodyPart').value;
        const exerciseName = document.getElementById('customExerciseName').value.trim();
        const exerciseDesc = document.getElementById('customExerciseDescription').value.trim();
        const exerciseLink = document.getElementById('customExerciseLink').value.trim() || '#';

        if (!exerciseName) {
            // Highlight the name field if empty
            document.getElementById('customExerciseName').classList.add('is-invalid');
            return;
        }

        // Add the exercise
        addExerciseToDay(day, bodyPart, exerciseName, exerciseDesc, exerciseLink);

        // Hide the modal
        const customExerciseModal = bootstrap.Modal.getInstance(document.getElementById('customExerciseModal'));
        customExerciseModal.hide();
    });

    // Remove invalid class when typing
    document.getElementById('customExerciseName').addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});

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

// Lägg till dessa modaler i slutet av body-taggen
document.addEventListener('DOMContentLoaded', function() {
    // Lägg till HTML för modaler om de inte redan finns
    if (!document.getElementById('successModal')) {
        const modalHTML = `
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">Operation Successful</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="successModalBody">
                        The operation completed successfully.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="confirmModalBody">
                        Are you sure you want to continue?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-warning" id="confirmModalYesBtn">Continue</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">An Error Occurred</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="errorModalBody">
                        An unexpected error has occurred.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>`;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
});

// Hjälpfunktioner för modaler
const CustomModals = {
    showSuccess: function(message, callback = null) {
        const modal = document.getElementById('successModal');
        const modalBody = document.getElementById('successModalBody');

        if (modal && modalBody) {
            modalBody.textContent = message;
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();

            if (callback) {
                modal.addEventListener('hidden.bs.modal', function handler() {
                    callback();
                    modal.removeEventListener('hidden.bs.modal', handler);
                });
            }
        } else {
            // Fallback till alert om modalen inte kan hittas
            alert(message);
            if (callback) callback();
        }
    },

    showError: function(message, callback = null) {
        const modal = document.getElementById('errorModal');
        const modalBody = document.getElementById('errorModalBody');

        if (modal && modalBody) {
            // Remove any existing backdrop - this is crucial to prevent backdrop from sticking
            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) {
                existingBackdrop.remove();
            }
            
            // Reset modal state
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            
            // Set the message and show the modal
            modalBody.textContent = message;
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
            
            // Add a handler to ensure proper cleanup when modal is hidden
            if (callback || true) { // Always add this handler
                modal.addEventListener('hidden.bs.modal', function handler() {
                    // Clean up
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    
                    // Make sure backdrop is removed
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    
                    // Call callback if provided
                    if (callback) callback();
                    
                    // Remove this handler to avoid multiple bindings
                    modal.removeEventListener('hidden.bs.modal', handler);
                });
            }
        } else {
            // Fallback to alert if modal can't be found
            alert(message);
            if (callback) callback();
        }
    },

    showConfirm: function(message, yesCallback, noCallback = null) {
        const modal = document.getElementById('confirmModal');
        const modalBody = document.getElementById('confirmModalBody');
        const yesBtn = document.getElementById('confirmModalYesBtn');

        if (modal && modalBody && yesBtn) {
            // Remove any existing backdrop - this is crucial to prevent backdrop from sticking
            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) {
                existingBackdrop.remove();
            }
            
            // Reset modal state
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            
            modalBody.textContent = message;

            // Ta bort tidigare eventlyssnare
            const newYesBtn = yesBtn.cloneNode(true);
            yesBtn.parentNode.replaceChild(newYesBtn, yesBtn);

            // Lägg till nya eventlyssnare
            newYesBtn.addEventListener('click', function() {
                bootstrap.Modal.getInstance(modal).hide();
                if (yesCallback) yesCallback();
            });

            if (noCallback) {
                modal.addEventListener('hidden.bs.modal', function handler() {
                    noCallback();
                    modal.removeEventListener('hidden.bs.modal', handler);
                });
            }
            
            // Add a handler to ensure proper cleanup when modal is hidden
            modal.addEventListener('hidden.bs.modal', function handler() {
                // Clean up
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Make sure backdrop is removed
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                
                // Remove this handler to avoid multiple bindings
                modal.removeEventListener('hidden.bs.modal', handler);
            });

            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else {
            // Fallback till confirm om modalen inte kan hittas
            const result = confirm(message);
            if (result && yesCallback) yesCallback();
            else if (!result && noCallback) noCallback();
        }
    }
};

// Namespace for workout.js functions to avoid conflicts with workout_log.js
const WorkoutSchedule = {
    // Function to get current user ID
    getUserId: function() {
        // Get user ID from PHP session - set in session_handler.php
        // Look for a hidden field with user ID that we'll add to the page
        const userIdField = document.getElementById('current_user_id');
        if (userIdField && userIdField.value) {
            return userIdField.value;
        }

        // Fallback to sessionstorage
        const sessionUserId = sessionStorage.getItem('logged_in_user_id');
        if (sessionUserId) {
            return sessionUserId;
        }

        // If all else fails, use the timestamp to create a unique ID for this browser
        // This ensures each browser/device at least sees its own workouts
        let uniqueBrowserId = localStorage.getItem('unique_browser_id');
        if (!uniqueBrowserId) {
            uniqueBrowserId = 'browser_' + Date.now();
            localStorage.setItem('unique_browser_id', uniqueBrowserId);
        }
        return uniqueBrowserId;
    },

    // Get workout days schedule for current user
    getSavedWorkoutDays: function() {
        const userId = this.getUserId();
        return JSON.parse(localStorage.getItem(`savedWorkoutDays_${userId}`)) || {};
    },

    // Save workout days schedule for current user
    saveSavedWorkoutDays: function(days) {
        const userId = this.getUserId();
        localStorage.setItem(`savedWorkoutDays_${userId}`, JSON.stringify(days));
    },

    // En flagga för att förhindra dubbla sparningar
    isSaving: false,

    // Modifierad saveWorkout-funktion
    saveWorkout: function(day) {
        // Förhindra dubbla sparningar
        if (this.isSaving) {
            console.log("Saving operation already in progress, ignoring duplicate call");
            return;
        }

        this.isSaving = true;
        console.log(`WorkoutSchedule.saveWorkout called for day: ${day}`);

        // Collect data from the selected day
        const selectedPartsContainer = document.querySelector(`#selected-parts-${day} .d-flex`);
        const selectedExercisesContainer = document.querySelector(`#selected-exercises-${day} .selected-exercises-container`);
        const notes = document.querySelector(`#notes-${day}`).value;

        // Check if there are any selected muscle groups or exercises
        if (!selectedPartsContainer || !selectedExercisesContainer) {
            console.error("Could not find selected parts or exercises container");
            CustomModals.showError("An error occurred: Could not find selected workout.");
            this.isSaving = false;
            return;
        }

        if (selectedPartsContainer.children.length === 0 || selectedExercisesContainer.children.length === 0) {
            CustomModals.showError("Please add at least one muscle group and exercise before saving.");
            this.isSaving = false;
            return;
        }

        // Collect muscle groups
        const bodyParts = [];
        Array.from(selectedPartsContainer.children).forEach(part => {
            bodyParts.push(part.textContent.trim().replace('×', '').trim());
        });

        // Collect exercises and details
        const exercises = [];
        Array.from(selectedExercisesContainer.children).forEach(exercise => {
            const name = exercise.querySelector('h6').textContent;
            const sets = exercise.querySelector('input[placeholder="Sets"]').value || '';
            const reps = exercise.querySelector('input[placeholder="Reps"]').value || '';
            const weight = exercise.querySelector('input[placeholder="Weight"]').value || '';

            const exerciseData = {
                name: name,
                category: this.getExerciseCategory(name) || bodyParts[0] || 'Other',
                sets: parseInt(sets) || 3,
                reps: parseInt(reps) || 10,
                weight: parseFloat(weight) || 0,
                notes: ''
            };

            exercises.push(exerciseData);
        });

        // Format day name correctly
        const dayFormatted = day.charAt(0).toUpperCase() + day.slice(1).toLowerCase();

        // Create workout object
        const workoutDay = {
            day: dayFormatted,
            date: new Date().toISOString(),
            focus: bodyParts,
            exercises: exercises,
            notes: notes
        };

        // Get existing saved workout days
        let savedWorkoutDays = this.getSavedWorkoutDays();

        // Save or update workout day
        savedWorkoutDays[day.toLowerCase()] = workoutDay;

        // Save to localStorage
        this.saveSavedWorkoutDays(savedWorkoutDays);

        // Also save as a workout template for use in workout_log
        const template = {
            id: this.generateUniqueId(),
            name: `${dayFormatted} Workout`,
            date: new Date().toISOString(),
            exercises: exercises,
            completed: false,
            isTemplate: true
        };

        // Get existing templates from localStorage
        const userId = this.getUserId();
        let templates = JSON.parse(localStorage.getItem(`workoutTemplates_${userId}`)) || [];

        // Check if a template for this day already exists
        const existingIndex = templates.findIndex(t => t.name === `${dayFormatted} Workout`);
        if (existingIndex !== -1) {
            templates[existingIndex] = template;
        } else {
            templates.push(template);
        }

        // Save templates back to localStorage
        localStorage.setItem(`workoutTemplates_${userId}`, JSON.stringify(templates));

        // Update UI
        this.renderSavedWorkouts();

        // Show confirmation med anpassad modal
        CustomModals.showSuccess(`Workout for ${dayFormatted} has been saved!`, () => {
            // Återställ sparningsflaggan efter att modalen har stängts
            this.isSaving = false;
        });
    },

    // Helper function to get the category of an exercise
    getExerciseCategory: function(exerciseName) {
        for (const category in exerciseDatabase) {
            const foundExercise = exerciseDatabase[category].find(ex =>
                (typeof ex === 'object' && ex.name === exerciseName)
            );
            if (foundExercise) {
                return category;
            }
        }
        return null;
    },

    // Generate a unique ID for workouts and templates
    generateUniqueId: function() {
        return Date.now() + Math.random().toString(36).substring(2, 9);
    },

    // Render saved workouts in UI
    renderSavedWorkouts: function() {
        console.log("renderSavedWorkouts called");
        const container = document.getElementById('saved-workouts-container');
        const noSavedWorkouts = document.getElementById('no-saved-workouts');

        if (!container || !noSavedWorkouts) {
            console.error("Could not find saved-workouts-container or no-saved-workouts element");
            return;
        }

        // Get saved workout days
        const savedWorkoutDays = this.getSavedWorkoutDays();
        console.log("Saved workout days:", savedWorkoutDays);

        // Show/hide "no saved workouts" message
        if (Object.keys(savedWorkoutDays).length === 0) {
            console.log("No saved workouts found, showing 'no-saved-workouts' message");
            noSavedWorkouts.style.display = 'block';

            // Clear container except for noSavedWorkouts element
            Array.from(container.children).forEach(child => {
                if (child.id !== 'no-saved-workouts') {
                    child.remove();
                }
            });
            return;
        } else {
            console.log(`Found ${Object.keys(savedWorkoutDays).length} saved workout days, hiding 'no-saved-workouts' message`);
            noSavedWorkouts.style.display = 'none';
        }

        // Clear container except for noSavedWorkouts element
        Array.from(container.children).forEach(child => {
            if (child.id !== 'no-saved-workouts') {
                child.remove();
            }
        });

        // Sort days in correct order
        const dayOrder = {
            'monday': 1, 'tuesday': 2, 'wednesday': 3, 'thursday': 4,
            'friday': 5, 'saturday': 6, 'sunday': 7
        };

        const sortedDays = Object.entries(savedWorkoutDays)
            .sort(([dayA], [dayB]) => dayOrder[dayA] - dayOrder[dayB]);
        
        console.log("Sorted workout days to render:", sortedDays.map(([day]) => day));

        // Render each workout day
        sortedDays.forEach(([day, workout]) => {
            console.log(`Rendering workout for ${day}`);
            const workoutCard = document.createElement('div');
            workoutCard.className = 'col-md-6 col-lg-4 mb-4';
            workoutCard.innerHTML = `
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title h5 fw-bold mb-0">${workout.day}</h3>
                            <div>
                                <button class="btn btn-sm btn-outline-success me-2 load-day-btn" 
                                        data-day="${day}"
                                        title="Load workout">
                                    <i class="lni lni-reload"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-primary me-2 edit-workout-btn" 
                                        data-day="${day}"
                                        title="Edit workout">
                                    <i class="lni lni-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-workout-btn" 
                                        data-day="${day}"
                                        title="Delete workout">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex flex-wrap gap-2">
                                ${workout.focus.map(part =>
                `<span class="badge bg-light text-primary">${part}</span>`
            ).join('')}
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted small text-uppercase fw-bold">Exercises</h6>
                            <ul class="list-group list-group-flush">
                                ${workout.exercises.map(exercise => `
                                    <li class="list-group-item px-0 py-2 border-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-medium">${exercise.name}</span>
                                            <span class="text-muted small">
                                                ${exercise.sets ? exercise.sets + ' sets' : ''}
                                                ${exercise.reps ? ' × ' + exercise.reps + ' reps' : ''}
                                                ${exercise.weight ? ' × ' + exercise.weight + ' kg' : ''}
                                            </span>
                                        </div>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                        
                        ${workout.notes ? `
                            <div class="mt-3">
                                <h6 class="text-muted small text-uppercase fw-bold">Notes</h6>
                                <p class="mb-0 text-muted small">${workout.notes}</p>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;

            container.appendChild(workoutCard);
            console.log(`Added workout card for ${day} to container`);

            // Add listeners to the buttons
            const loadBtn = workoutCard.querySelector('.load-day-btn');
            const editBtn = workoutCard.querySelector('.edit-workout-btn');
            const deleteBtn = workoutCard.querySelector('.delete-workout-btn');

            loadBtn.addEventListener('click', () => this.loadWorkout(day));
            editBtn.addEventListener('click', () => this.editWorkout(day));
            deleteBtn.addEventListener('click', () => this.deleteWorkout(day));
        });
    },

    // Load a workout day
    loadWorkout: function(day) {
        // Get saved workout days
        const savedWorkoutDays = this.getSavedWorkoutDays();
        const workout = savedWorkoutDays[day.toLowerCase()];

        if (!workout) {
            alert(`No saved workout found for ${day}.`);
            return;
        }

        const dayLower = day.toLowerCase();

        // Clear existing selections
        document.querySelector(`#selected-parts-${dayLower} .d-flex`).innerHTML = '';
        document.querySelector(`#selected-exercises-${dayLower} .selected-exercises-container`).innerHTML = '';
        document.querySelector(`#notes-${dayLower}`).value = workout.notes || '';

        // Uncheck all checkboxes
        document.querySelectorAll(`input[id^="${dayLower}-"]`).forEach(checkbox => {
            checkbox.checked = false;
        });

        // Check the selected body parts
        workout.focus.forEach(part => {
            const checkbox = document.getElementById(`${dayLower}-${part.toLowerCase().replace(' ', '-')}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        // Update UI for selected body parts
        updateWorkoutFocus(dayLower);

        // Add the exercises
        workout.exercises.forEach(exercise => {
            // Find matching body part for the exercise
            let matchedBodyPart = '';
            for (const part in exerciseDatabase) {
                const foundExercise = exerciseDatabase[part].find(e =>
                    (typeof e === 'object' && e.name === exercise.name) || e === exercise.name
                );
                if (foundExercise) {
                    matchedBodyPart = part;
                    break;
                }
            }

            if (!matchedBodyPart && workout.focus.length > 0) {
                matchedBodyPart = workout.focus[0];
            }

            // Find exercise info if it exists in the database
            let exerciseInfo = { desc: '', link: '#' };
            if (matchedBodyPart && exerciseDatabase[matchedBodyPart]) {
                const foundExercise = exerciseDatabase[matchedBodyPart].find(e =>
                    (typeof e === 'object' && e.name === exercise.name)
                );
                if (foundExercise) {
                    exerciseInfo.desc = foundExercise.desc || '';
                    exerciseInfo.link = foundExercise.link || '#';
                }
            }

            // Create exercise element
            const container = document.querySelector(`#selected-exercises-${dayLower} .selected-exercises-container`);
            const exerciseElement = document.createElement('div');
            exerciseElement.className = 'selected-exercise-item mb-3 p-3 bg-light rounded-3';
            exerciseElement.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <h6 class="mb-0 fw-bold">${exercise.name}</h6>
                        <button class="btn btn-link p-0 exercise-info" 
                                onclick="showExerciseInfo('${exercise.name}', '${exerciseInfo.desc}', '${exerciseInfo.link}')">
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
                            <input type="text" class="form-control form-control-sm" placeholder="Sets" value="${exercise.sets || ''}">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" placeholder="Reps" value="${exercise.reps || ''}">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm" placeholder="Weight" value="${exercise.weight || ''}">
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(exerciseElement);
        });

        // Show add-exercise button
        document.querySelector(`#selected-exercises-${dayLower} .add-exercise-btn`).style.display = 'inline-flex';

        // Scroll to the day
        document.querySelector(`#dropdown-${dayLower}`).scrollIntoView({ behavior: 'smooth', block: 'center' });
    },

    // Edit workout
    editWorkout: function(day) {
        // Find corresponding day in UI and scroll to it
        const dayElements = document.querySelectorAll('.card-title.h4');
        let foundElement = null;

        dayElements.forEach(element => {
            if (element.textContent.trim().toLowerCase() === day.toLowerCase()) {
                foundElement = element;
            }
        });

        if (foundElement) {
            foundElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Highlight the card to draw attention to it
            const card = foundElement.closest('.card');
            card.classList.add('border-primary');
            setTimeout(() => {
                card.classList.remove('border-primary');
            }, 2000);
        }
    },

    // Delete workout
    deleteWorkout: function(day) {
        CustomModals.showConfirm(`Are you sure you want to delete the workout for ${day}?`, () => {
            // Get saved workout days
            let savedWorkoutDays = this.getSavedWorkoutDays();

            // Delete workout for selected day
            delete savedWorkoutDays[day.toLowerCase()];

            // Save updated list
            this.saveSavedWorkoutDays(savedWorkoutDays);

            // Update UI
            this.renderSavedWorkouts();

            // Visa bekräftelse
            CustomModals.showSuccess(`The workout for ${day} has been deleted.`);
        });
    },

    // Initialize - call this when the document is loaded
    init: function() {
        console.log("WorkoutSchedule.init() called");
        
        // Force a clean render of saved workouts
        setTimeout(() => {
            console.log("Rendering saved workouts with timeout to ensure DOM is ready");
            this.renderSavedWorkouts();
        }, 300);

        // Add click listeners to Save Workout buttons
        document.querySelectorAll('.btn-primary.btn-lg').forEach(button => {
            if (button.textContent.includes('Save Workout')) {
                console.log("Adding click listener to Save Workout button", button);
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const card = button.closest('.card');
                    if (card) {
                        const dayElement = card.querySelector('.card-title.h4');
                        if (dayElement) {
                            const day = dayElement.textContent;
                            console.log(`Save button clicked for ${day}`);
                            this.saveWorkout(day.toLowerCase());
                        } else {
                            console.error("Could not find day element in card");
                        }
                    } else {
                        console.error("Could not find parent card element");
                    }
                });
            }
        });
    }
};

// Add event listeners when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded - Setting up event listeners");

    // Force clean start of WorkoutSchedule
    const container = document.getElementById('saved-workouts-container');
    if (container) {
        console.log("Found saved-workouts-container, initializing WorkoutSchedule");
        
        // Create a clean start by making sure container only has no-saved-workouts initially
        const noSavedWorkouts = document.getElementById('no-saved-workouts');
        if (noSavedWorkouts) {
            // Preserve no-saved-workouts element but remove anything else
            Array.from(container.children).forEach(child => {
                if (child.id !== 'no-saved-workouts') {
                    child.remove();
                }
            });
        }
    } else {
        console.error("Could not find saved-workouts-container element");
    }
    
    // Set up clear workouts button
    const clearWorkoutsBtn = document.getElementById('clear-workouts-btn');
    if (clearWorkoutsBtn) {
        clearWorkoutsBtn.addEventListener('click', function() {
            CustomModals.showConfirm("Are you sure you want to clear all saved workouts?", () => {
                // Clear all saved workout days
                const userId = WorkoutSchedule.getUserId();
                localStorage.removeItem(`savedWorkoutDays_${userId}`);
                
                // Re-render the UI
                WorkoutSchedule.renderSavedWorkouts();
                
                // Show confirmation
                CustomModals.showSuccess("All saved workout days have been cleared.");
            });
        });
    }

    // Initialize the WorkoutSchedule
    WorkoutSchedule.init();

    // Add direct event listeners to all save buttons to ensure they work
    document.querySelectorAll('.btn-primary.btn-lg').forEach(button => {
        // Check if button contains the text "Save Workout" or has the save icon
        if (button.innerHTML.includes('Save Workout') || button.innerHTML.includes('lni-save')) {
            console.log("Adding direct click listener to Save Workout button");
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const card = this.closest('.card');
                if (card) {
                    const dayElement = card.querySelector('.card-title.h4');
                    if (dayElement) {
                        const day = dayElement.textContent;
                        console.log(`Direct save handler: button clicked for ${day}`);
                        WorkoutSchedule.saveWorkout(day.toLowerCase());
                    } else {
                        console.error("Could not find day element in direct handler");
                    }
                } else {
                    console.error("Could not find parent card element in direct handler");
                }
            });
        }
    });

    // Additional check for save buttons that might be missed by the selector
    setTimeout(function() {
        const allButtons = document.querySelectorAll('button');
        allButtons.forEach(btn => {
            if ((btn.innerHTML.includes('Save Workout') || btn.innerHTML.includes('lni-save')) &&
                !btn.hasAttribute('data-save-listener')) {

                console.log("Adding delayed listener to missed Save Workout button");
                btn.setAttribute('data-save-listener', 'true');
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const card = this.closest('.card');
                    if (card) {
                        const dayElement = card.querySelector('.card-title.h4');
                        if (dayElement) {
                            const day = dayElement.textContent;
                            console.log(`Delayed handler: Save button clicked for ${day}`);
                            WorkoutSchedule.saveWorkout(day.toLowerCase());
                        }
                    }
                });
            }
        });
    }, 1000); // Check after a short delay to catch any dynamically added buttons
});

// Function to load a pre-made professional workout program
function loadProgram(programId) {
    // Show loading indicator
    const loadingToast = new bootstrap.Toast(document.getElementById('loadingToast'));
    if (document.getElementById('loadingToast')) {
        loadingToast.show();
    } else {
        // Create a toast if it doesn't exist
        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.innerHTML = `
            <div id="loadingToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-primary text-white">
                    <i class="lni lni-spinner-solid me-2"></i>
                    <strong class="me-auto">Loading Program</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Loading your professional workout program...
                </div>
            </div>
        `;
        document.body.appendChild(toastContainer);
        const loadingToast = new bootstrap.Toast(document.getElementById('loadingToast'));
        loadingToast.show();
    }

    // Define workout programs (in a real app, this would come from a database)
    const programs = {
        '12-week-strength': {
            name: '12-Week Strength Builder',
            author: 'Alex Johnson, CSCS',
            level: 'Advanced',
            color: 'primary',
            description: 'A comprehensive strength program designed to increase your overall power and muscle mass through progressive overload principles. This 12-week program follows a structured progression to ensure continuous strength gains.',
            features: [
                '4 workout days per week',
                'Focus on compound movements',
                'Progressive overload system',
                'Weekly progression tracking',
                'Includes deload weeks'
            ],
            days: {
                'monday': {
                    focus: ['Chest', 'Shoulders', 'Triceps'],
                    exercises: [
                        { name: 'Barbell Bench Press', sets: 4, reps: '6-8', notes: 'Progressive overload focus' },
                        { name: 'Incline Dumbbell Press', sets: 3, reps: '8-10', notes: 'Control the negative' },
                        { name: 'Overhead Press', sets: 3, reps: '8-10', notes: 'Strict form' },
                        { name: 'Dips', sets: 3, reps: '8-12', notes: 'Body weight or assisted' },
                        { name: 'Tricep Pushdowns', sets: 3, reps: '10-12', notes: 'Focus on contraction' }
                    ],
                    notes: 'Week 1: Focus on form and establishing baseline weights. Rest 2 minutes between compound movements, 90 seconds for accessories.'
                },
                'wednesday': {
                    focus: ['Back', 'Biceps'],
                    exercises: [
                        { name: 'Pull-Ups', sets: 4, reps: '6-8', notes: 'Wide grip' },
                        { name: 'Barbell Rows', sets: 3, reps: '8-10', notes: 'Bend at 45 degrees' },
                        { name: 'Lat Pulldowns', sets: 3, reps: '10-12', notes: 'Full range of motion' },
                        { name: 'Face Pulls', sets: 3, reps: '12-15', notes: 'Focus on rear delts' },
                        { name: 'Barbell Curls', sets: 3, reps: '10-12', notes: 'Control the movement' }
                    ],
                    notes: 'Ensure proper back engagement. Focus on the mind-muscle connection for each exercise.'
                },
                'friday': {
                    focus: ['Legs', 'Core'],
                    exercises: [
                        { name: 'Barbell Squats', sets: 4, reps: '6-8', notes: 'Full depth' },
                        { name: 'Romanian Deadlifts', sets: 3, reps: '8-10', notes: 'Keep back flat' },
                        { name: 'Leg Press', sets: 3, reps: '10-12', notes: 'Varying foot positions' },
                        { name: 'Leg Extensions', sets: 3, reps: '12-15', notes: 'Quad focus' },
                        { name: 'Planks', sets: 3, reps: '30-60 seconds', notes: 'Keep body straight' }
                    ],
                    notes: 'Warm up properly before heavy squats and deadlifts. Stretch after the workout.'
                },
                'saturday': {
                    focus: ['Full Body', 'Shoulders'],
                    exercises: [
                        { name: 'Dumbbell Shoulder Press', sets: 4, reps: '8-10', notes: 'Seated or standing' },
                        { name: 'Lateral Raises', sets: 3, reps: '10-12', notes: 'Light weight, perfect form' },
                        { name: 'Upright Rows', sets: 3, reps: '10-12', notes: 'Shoulder width grip' },
                        { name: 'Shrugs', sets: 3, reps: '12-15', notes: 'Hold at the top' },
                        { name: 'Abs Circuit', sets: 3, reps: 'Circuit style', notes: 'Minimal rest between exercises' }
                    ],
                    notes: 'This is a shoulder focus day with some additional work. Increase weight from previous week if possible.'
                }
            }
        },
        '30-day-hiit': {
            name: '30-Day HIIT Challenge',
            author: 'Sarah Miller, CPT',
            level: 'Intermediate',
            color: 'success',
            description: 'Transform your body in just 30 days with this high-intensity interval training program designed for maximum calorie burn. This challenge is perfect for those looking to improve cardiovascular fitness and shed unwanted body fat.',
            features: [
                '5 workout days per week',
                '30-minute high-intensity workouts',
                'Minimal equipment needed',
                'Scalable difficulty levels',
                'Includes active recovery days'
            ],
            days: {
                'monday': {
                    focus: ['Cardio', 'Full Body'],
                    exercises: [
                        { name: 'Jumping Jacks', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Burpees', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Full body movement' },
                        { name: 'Mountain Climbers', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Keep core tight' },
                        { name: 'Jumping Squats', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Explosive movement' },
                        { name: 'Push-up to Plank Jack', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Modify as needed' }
                    ],
                    notes: 'Complete all exercises in circuit fashion. Rest 1 minute between circuits. Aim for maximum effort during work periods.'
                },
                'tuesday': {
                    focus: ['Cardio', 'Core'],
                    exercises: [
                        { name: 'High Knees', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Russian Twists', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Use medicine ball if available' },
                        { name: 'Bicycle Crunches', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Control the movement' },
                        { name: 'Plank Shoulder Taps', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Keep hips stable' },
                        { name: 'Scissor Kicks', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Lower back flat on ground' }
                    ],
                    notes: 'Core-focused HIIT workout. Focus on form and bracing your core throughout.'
                },
                'thursday': {
                    focus: ['Cardio', 'Lower Body'],
                    exercises: [
                        { name: 'Skater Hops', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Squat Pulses', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Keep tension throughout' },
                        { name: 'Alternating Lunges', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Step back lunges' },
                        { name: 'Glute Bridges', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Squeeze at the top' },
                        { name: 'Wall Sit', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: '90 degree knee angle' }
                    ],
                    notes: 'Lower body focus with cardio elements. Challenge yourself to maintain proper form even when fatigued.'
                },
                'friday': {
                    focus: ['Cardio', 'Upper Body'],
                    exercises: [
                        { name: 'Arm Circles', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Push-ups', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Modify as needed' },
                        { name: 'Tricep Dips', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Use bench or chair' },
                        { name: 'Plank Up-Downs', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Alternate lead arm' },
                        { name: 'Superman Holds', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Engage back muscles' }
                    ],
                    notes: 'Upper body focus with minimal equipment. Aim for quality repetitions rather than rushing through.'
                },
                'saturday': {
                    focus: ['Cardio', 'Full Body'],
                    exercises: [
                        { name: 'Jumping Rope', sets: 3, reps: '30 seconds', notes: 'Active warmup (simulate if no rope)' },
                        { name: 'Lateral Lunges', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Step wide' },
                        { name: 'Shoulder Taps', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'High plank position' },
                        { name: 'Sumo Squats', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Wide stance' },
                        { name: 'Burpee to Tuck Jump', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Maximum effort' }
                    ],
                    notes: 'This is the most challenging workout of the week. Push through and give it your all on the final day!'
                }
            }
        },
        'beginners-full-body': {
            name: 'Beginner\'s Full Body Plan',
            author: 'Michael Chen, NASM-CPT',
            level: 'Beginner',
            color: 'info',
            description: 'Perfect for newcomers to fitness, this plan focuses on building foundational strength and proper form with full-body workouts. This program eases you into consistent exercise with clear instructions and proper progression.',
            features: [
                '3 workout days per week',
                'Form-focused exercises',
                'Beginner-friendly progression',
                'Full body approach for balanced development'
            ],
            days: {
                'monday': {
                    focus: ['Full Body'],
                    exercises: [
                        { name: 'Bodyweight Squats', sets: 3, reps: '12-15', notes: 'Focus on form and depth' },
                        { name: 'Push-ups (Modified if needed)', sets: 3, reps: '8-12', notes: 'Keep body straight' },
                        { name: 'Dumbbell Rows', sets: 3, reps: '10-12', notes: 'One arm at a time' },
                        { name: 'Glute Bridges', sets: 3, reps: '12-15', notes: 'Squeeze at the top' },
                        { name: 'Plank', sets: 3, reps: '20-30 seconds', notes: 'Hold steady' }
                    ],
                    notes: 'Take your time with each exercise and focus on proper form. Rest 90 seconds between sets. This workout builds foundational strength.'
                },
                'wednesday': {
                    focus: ['Full Body'],
                    exercises: [
                        { name: 'Dumbbell Lunges', sets: 3, reps: '10 each leg', notes: 'Step forward or backward' },
                        { name: 'Seated Dumbbell Shoulder Press', sets: 3, reps: '10-12', notes: 'Light weights' },
                        { name: 'Lat Pulldowns', sets: 3, reps: '10-12', notes: 'Use machine or resistance band' },
                        { name: 'Dumbbell Curls', sets: 2, reps: '12-15', notes: 'Alternating arms' },
                        { name: 'Bird-dog', sets: 2, reps: '10 each side', notes: 'Maintain balance' }
                    ],
                    notes: 'Slightly different exercise selection from Monday to target muscles from different angles. Focus on controlled movements.'
                },
                'friday': {
                    focus: ['Full Body'],
                    exercises: [
                        { name: 'Goblet Squats', sets: 3, reps: '10-12', notes: 'Hold dumbbell or kettlebell' },
                        { name: 'Incline Push-ups', sets: 3, reps: '10-12', notes: 'Hands on bench or step' },
                        { name: 'Seated Cable Rows', sets: 3, reps: '10-12', notes: 'Pull to mid-stomach' },
                        { name: 'Dumbbell Lateral Raises', sets: 2, reps: '12-15', notes: 'Very light weight' },
                        { name: 'Superman', sets: 2, reps: '10-12', notes: 'Hold for 2 seconds' }
                    ],
                    notes: 'Final workout of the week. Pay attention to any areas that feel particularly challenging, as these may be weak points to focus on.'
                }
            }
        }
    };

    // Retrieve the selected program
    const program = programs[programId];
    if (!program) {
        console.error('Program not found:', programId);
        alert('Sorry, this program is currently unavailable.');
        return;
    }

    // Clear existing selections for all days
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    days.forEach(day => {
        // Clear any existing selections
        document.querySelector(`#selected-parts-${day} .d-flex`).innerHTML = '';
        document.querySelector(`#selected-exercises-${day} .selected-exercises-container`).innerHTML = '';
        
        // Reset notes
        if (document.getElementById(`notes-${day}`)) {
            document.getElementById(`notes-${day}`).value = '';
        }

        // Show the add exercise button if needed
        const addExerciseBtn = document.querySelector(`#selected-exercises-${day} .add-exercise-btn`);
        if (addExerciseBtn) {
            addExerciseBtn.style.display = 'none';
        }
    });

    // Apply the program to each day
    Object.keys(program.days).forEach(day => {
        const dayData = program.days[day];
        const bodyParts = dayData.focus;
        
        // Set the selected body parts
        const selectedPartsDiv = document.querySelector(`#selected-parts-${day} .d-flex`);
        if (selectedPartsDiv) {
            bodyParts.forEach(part => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary rounded-pill px-3 py-2';
                badge.textContent = part;
                selectedPartsDiv.appendChild(badge);
                
                // Check the corresponding checkbox in the dropdown (if it exists)
                const checkbox = document.getElementById(`${day}-${part.toLowerCase().replace(' ', '-')}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
        
        // Add exercises
        const exercisesContainer = document.querySelector(`#selected-exercises-${day} .selected-exercises-container`);
        if (exercisesContainer) {
            dayData.exercises.forEach((exercise, index) => {
                const exerciseDiv = document.createElement('div');
                exerciseDiv.className = 'selected-exercise-item mb-3 p-3 bg-light rounded-3';
                exerciseDiv.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0 fw-bold">${exercise.name}</h6>
                            <button class="btn btn-link p-0 exercise-info" 
                                    onclick="showExerciseInfo('${exercise.name}', '${exercise.notes || ''}', '#')">
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
                                <input type="text" class="form-control form-control-sm" placeholder="Sets" value="${exercise.sets || ''}">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm" placeholder="Reps" value="${exercise.reps || ''}">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm" placeholder="Weight" value="">
                            </div>
                        </div>
                    </div>
                `;
                exercisesContainer.appendChild(exerciseDiv);
            });
            
            // Show the add exercise button
            const addExerciseBtn = document.querySelector(`#selected-exercises-${day} .add-exercise-btn`);
            if (addExerciseBtn) {
                addExerciseBtn.style.display = 'block';
            }
        }
        
        // Set notes
        if (document.getElementById(`notes-${day}`)) {
            document.getElementById(`notes-${day}`).value = dayData.notes || '';
        }
    });

    // Scroll to the top of the workout cards
    document.querySelector('.row.g-4').scrollIntoView({ behavior: 'smooth' });
    
    // Show a success message
    setTimeout(() => {
        if (document.getElementById('loadingToast')) {
            const loadingToast = bootstrap.Toast.getInstance(document.getElementById('loadingToast'));
            loadingToast.hide();
        }
        
        // Create a success toast
        const successToastContainer = document.createElement('div');
        successToastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        successToastContainer.innerHTML = `
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <i class="lni lni-checkmark-circle me-2"></i>
                    <strong class="me-auto">Program Loaded</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <p class="mb-1"><strong>${program.name}</strong> has been loaded successfully!</p>
                    <p class="mb-0 small text-muted">Created by ${program.author}</p>
                    <p class="mt-2 mb-0"><strong>Important:</strong> Don't forget to click 'Save Workout' for each day to save your program!</p>
                </div>
            </div>
        `;
        document.body.appendChild(successToastContainer);
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        successToast.show();
        
        // Re-attach event listeners to Save Workout buttons after loading the program
        setTimeout(() => {
            console.log("Re-attaching event listeners to Save Workout buttons after program load");
            
            document.querySelectorAll('.btn-primary.btn-lg').forEach(button => {
                // Check if button has save workout text or save icon and doesn't already have a listener
                if ((button.innerHTML.includes('Save Workout') || button.innerHTML.includes('lni-save')) && 
                    !button.hasAttribute('data-save-listener')) {
                    
                    console.log("Adding event listener to Save Workout button after program load:", button);
                    
                    button.setAttribute('data-save-listener', 'true');
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const card = this.closest('.card');
                        if (card) {
                            const dayElement = card.querySelector('.card-title.h4');
                            if (dayElement) {
                                const day = dayElement.textContent;
                                console.log(`Save button clicked for ${day} after program load`);
                                WorkoutSchedule.saveWorkout(day.toLowerCase());
                            } else {
                                console.error("Could not find day element in post-load handler");
                            }
                        } else {
                            console.error("Could not find parent card element in post-load handler");
                        }
                    });
                }
            });
        }, 500);
    }, 1000);
}

// Function to display program details in a modal
function viewProgramDetails(programId) {
    // Define workout programs (in a real app, this would come from a database)
    const programs = {
        '12-week-strength': {
            name: '12-Week Strength Builder',
            author: 'Alex Johnson, CSCS',
            level: 'Advanced',
            color: 'primary',
            description: 'A comprehensive strength program designed to increase your overall power and muscle mass through progressive overload principles. This 12-week program follows a structured progression to ensure continuous strength gains.',
            features: [
                '4 workout days per week',
                'Focus on compound movements',
                'Progressive overload system',
                'Weekly progression tracking',
                'Includes deload weeks'
            ],
            days: {
                'monday': {
                    focus: ['Chest', 'Shoulders', 'Triceps'],
                    exercises: [
                        { name: 'Barbell Bench Press', sets: 4, reps: '6-8', notes: 'Progressive overload focus' },
                        { name: 'Incline Dumbbell Press', sets: 3, reps: '8-10', notes: 'Control the negative' },
                        { name: 'Overhead Press', sets: 3, reps: '8-10', notes: 'Strict form' },
                        { name: 'Dips', sets: 3, reps: '8-12', notes: 'Body weight or assisted' },
                        { name: 'Tricep Pushdowns', sets: 3, reps: '10-12', notes: 'Focus on contraction' }
                    ],
                    notes: 'Week 1: Focus on form and establishing baseline weights. Rest 2 minutes between compound movements, 90 seconds for accessories.'
                },
                'wednesday': {
                    focus: ['Back', 'Biceps'],
                    exercises: [
                        { name: 'Pull-Ups', sets: 4, reps: '6-8', notes: 'Wide grip' },
                        { name: 'Barbell Rows', sets: 3, reps: '8-10', notes: 'Bend at 45 degrees' },
                        { name: 'Lat Pulldowns', sets: 3, reps: '10-12', notes: 'Full range of motion' },
                        { name: 'Face Pulls', sets: 3, reps: '12-15', notes: 'Focus on rear delts' },
                        { name: 'Barbell Curls', sets: 3, reps: '10-12', notes: 'Control the movement' }
                    ],
                    notes: 'Ensure proper back engagement. Focus on the mind-muscle connection for each exercise.'
                },
                'friday': {
                    focus: ['Legs', 'Core'],
                    exercises: [
                        { name: 'Barbell Squats', sets: 4, reps: '6-8', notes: 'Full depth' },
                        { name: 'Romanian Deadlifts', sets: 3, reps: '8-10', notes: 'Keep back flat' },
                        { name: 'Leg Press', sets: 3, reps: '10-12', notes: 'Varying foot positions' },
                        { name: 'Leg Extensions', sets: 3, reps: '12-15', notes: 'Quad focus' },
                        { name: 'Planks', sets: 3, reps: '30-60 seconds', notes: 'Keep body straight' }
                    ],
                    notes: 'Warm up properly before heavy squats and deadlifts. Stretch after the workout.'
                },
                'saturday': {
                    focus: ['Full Body', 'Shoulders'],
                    exercises: [
                        { name: 'Dumbbell Shoulder Press', sets: 4, reps: '8-10', notes: 'Seated or standing' },
                        { name: 'Lateral Raises', sets: 3, reps: '10-12', notes: 'Light weight, perfect form' },
                        { name: 'Upright Rows', sets: 3, reps: '10-12', notes: 'Shoulder width grip' },
                        { name: 'Shrugs', sets: 3, reps: '12-15', notes: 'Hold at the top' },
                        { name: 'Abs Circuit', sets: 3, reps: 'Circuit style', notes: 'Minimal rest between exercises' }
                    ],
                    notes: 'This is a shoulder focus day with some additional work. Increase weight from previous week if possible.'
                }
            }
        },
        '30-day-hiit': {
            name: '30-Day HIIT Challenge',
            author: 'Sarah Miller, CPT',
            level: 'Intermediate',
            color: 'success',
            description: 'Transform your body in just 30 days with this high-intensity interval training program designed for maximum calorie burn. This challenge is perfect for those looking to improve cardiovascular fitness and shed unwanted body fat.',
            features: [
                '5 workout days per week',
                '30-minute high-intensity workouts',
                'Minimal equipment needed',
                'Scalable difficulty levels',
                'Includes active recovery days'
            ],
            days: {
                'monday': {
                    focus: ['Cardio', 'Full Body'],
                    exercises: [
                        { name: 'Jumping Jacks', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Burpees', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Full body movement' },
                        { name: 'Mountain Climbers', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Keep core tight' },
                        { name: 'Jumping Squats', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Explosive movement' },
                        { name: 'Push-up to Plank Jack', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Modify as needed' }
                    ],
                    notes: 'Complete all exercises in circuit fashion. Rest 1 minute between circuits. Aim for maximum effort during work periods.'
                },
                'tuesday': {
                    focus: ['Cardio', 'Core'],
                    exercises: [
                        { name: 'High Knees', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Russian Twists', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Use medicine ball if available' },
                        { name: 'Bicycle Crunches', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Control the movement' },
                        { name: 'Plank Shoulder Taps', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Keep hips stable' },
                        { name: 'Scissor Kicks', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Lower back flat on ground' }
                    ],
                    notes: 'Core-focused HIIT workout. Focus on form and bracing your core throughout.'
                },
                'thursday': {
                    focus: ['Cardio', 'Lower Body'],
                    exercises: [
                        { name: 'Skater Hops', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Squat Pulses', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Keep tension throughout' },
                        { name: 'Alternating Lunges', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Step back lunges' },
                        { name: 'Glute Bridges', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Squeeze at the top' },
                        { name: 'Wall Sit', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: '90 degree knee angle' }
                    ],
                    notes: 'Lower body focus with cardio elements. Challenge yourself to maintain proper form even when fatigued.'
                },
                'friday': {
                    focus: ['Cardio', 'Upper Body'],
                    exercises: [
                        { name: 'Arm Circles', sets: 3, reps: '30 seconds', notes: 'Active warmup' },
                        { name: 'Push-ups', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Modify as needed' },
                        { name: 'Tricep Dips', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Use bench or chair' },
                        { name: 'Plank Up-Downs', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Alternate lead arm' },
                        { name: 'Superman Holds', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Engage back muscles' }
                    ],
                    notes: 'Upper body focus with minimal equipment. Aim for quality repetitions rather than rushing through.'
                },
                'saturday': {
                    focus: ['Cardio', 'Full Body'],
                    exercises: [
                        { name: 'Jumping Rope', sets: 3, reps: '30 seconds', notes: 'Active warmup (simulate if no rope)' },
                        { name: 'Lateral Lunges', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Step wide' },
                        { name: 'Shoulder Taps', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'High plank position' },
                        { name: 'Sumo Squats', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Wide stance' },
                        { name: 'Burpee to Tuck Jump', sets: 4, reps: '30 seconds work, 15 seconds rest', notes: 'Maximum effort' }
                    ],
                    notes: 'This is the most challenging workout of the week. Push through and give it your all on the final day!'
                }
            }
        },
        'beginners-full-body': {
            name: 'Beginner\'s Full Body Plan',
            author: 'Michael Chen, NASM-CPT',
            level: 'Beginner',
            color: 'info',
            description: 'Perfect for newcomers to fitness, this plan focuses on building foundational strength and proper form with full-body workouts. This program eases you into consistent exercise with clear instructions and proper progression.',
            features: [
                '3 workout days per week',
                'Form-focused exercises',
                'Beginner-friendly progression',
                'Full body approach for balanced development'
            ],
            days: {
                'monday': {
                    focus: ['Full Body'],
                    exercises: [
                        { name: 'Bodyweight Squats', sets: 3, reps: '12-15', notes: 'Focus on form and depth' },
                        { name: 'Push-ups (Modified if needed)', sets: 3, reps: '8-12', notes: 'Keep body straight' },
                        { name: 'Dumbbell Rows', sets: 3, reps: '10-12', notes: 'One arm at a time' },
                        { name: 'Glute Bridges', sets: 3, reps: '12-15', notes: 'Squeeze at the top' },
                        { name: 'Plank', sets: 3, reps: '20-30 seconds', notes: 'Hold steady' }
                    ],
                    notes: 'Take your time with each exercise and focus on proper form. Rest 90 seconds between sets. This workout builds foundational strength.'
                },
                'wednesday': {
                    focus: ['Full Body'],
                    exercises: [
                        { name: 'Dumbbell Lunges', sets: 3, reps: '10 each leg', notes: 'Step forward or backward' },
                        { name: 'Seated Dumbbell Shoulder Press', sets: 3, reps: '10-12', notes: 'Light weights' },
                        { name: 'Lat Pulldowns', sets: 3, reps: '10-12', notes: 'Use machine or resistance band' },
                        { name: 'Dumbbell Curls', sets: 2, reps: '12-15', notes: 'Alternating arms' },
                        { name: 'Bird-dog', sets: 2, reps: '10 each side', notes: 'Maintain balance' }
                    ],
                    notes: 'Slightly different exercise selection from Monday to target muscles from different angles. Focus on controlled movements.'
                },
                'friday': {
                    focus: ['Full Body'],
                    exercises: [
                        { name: 'Goblet Squats', sets: 3, reps: '10-12', notes: 'Hold dumbbell or kettlebell' },
                        { name: 'Incline Push-ups', sets: 3, reps: '10-12', notes: 'Hands on bench or step' },
                        { name: 'Seated Cable Rows', sets: 3, reps: '10-12', notes: 'Pull to mid-stomach' },
                        { name: 'Dumbbell Lateral Raises', sets: 2, reps: '12-15', notes: 'Very light weight' },
                        { name: 'Superman', sets: 2, reps: '10-12', notes: 'Hold for 2 seconds' }
                    ],
                    notes: 'Final workout of the week. Pay attention to any areas that feel particularly challenging, as these may be weak points to focus on.'
                }
            }
        }
    };

    const program = programs[programId];
    if (!program) {
        console.error('Program not found:', programId);
        alert('Sorry, this program is currently unavailable.');
        return;
    }

    // Set modal title and header color
    const modalTitle = document.getElementById('programDetailsTitle');
    const modalHeader = document.getElementById('programDetailsHeader');
    modalTitle.textContent = program.name;
    
    // Set header color based on program
    modalHeader.className = 'modal-header bg-' + program.color + ' text-white';
    
    // Generate modal body content
    const modalBody = document.getElementById('programDetailsBody');
    
    let modalContent = `
        <div class="mb-4">
            <span class="badge bg-${program.color} mb-2">${program.level}</span>
            <p class="lead">${program.description}</p>
        </div>
        
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">Program Features</h5>
            <ul class="list-group list-group-flush">
                ${program.features.map(feature => `
                    <li class="list-group-item px-0 d-flex align-items-center">
                        <i class="lni lni-checkmark-circle text-${program.color} me-2"></i> ${feature}
                    </li>
                `).join('')}
            </ul>
        </div>
        
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">Weekly Schedule</h5>
            <div class="row g-3">
    `;
    
    // Add day cards to the modal
    Object.keys(program.days).forEach(day => {
        const dayData = program.days[day];
        // Format day name
        const dayName = day.charAt(0).toUpperCase() + day.slice(1);
        
        modalContent += `
            <div class="col-md-6">
                <div class="card h-100 bg-light border-0 rounded-3">
                    <div class="card-header bg-${program.color} bg-opacity-10 border-0">
                        <h6 class="mb-0 fw-bold">${dayName}</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <small class="text-muted">Focus:</small>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                ${dayData.focus.map(focus => `
                                    <span class="badge bg-${program.color} bg-opacity-75 rounded-pill">${focus}</span>
                                `).join('')}
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">Exercises:</small>
                            <ul class="list-group list-group-flush mt-1">
                                ${dayData.exercises.map(exercise => `
                                    <li class="list-group-item px-0 py-2 border-0 bg-transparent">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-medium">${exercise.name}</span>
                                            <small>${exercise.sets} sets × ${exercise.reps}</small>
                                        </div>
                                        <small class="text-muted d-block mt-1">${exercise.notes}</small>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    modalContent += `
            </div>
        </div>
    `;
    
    modalBody.innerHTML = modalContent;
    
    // Set up the "Use This Program" button
    const useThisProgramBtn = document.getElementById('useThisProgramBtn');
    useThisProgramBtn.className = `btn btn-${program.color}`;
    useThisProgramBtn.onclick = function() {
        // Close the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('programDetailsModal'));
        modal.hide();
        
        // Load the program
        loadProgram(programId);
    };
    
    // Show the modal
    const programDetailsModal = new bootstrap.Modal(document.getElementById('programDetailsModal'));
    programDetailsModal.show();
} 