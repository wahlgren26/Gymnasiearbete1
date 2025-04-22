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
    
    showError: function(message) {
        const modal = document.getElementById('errorModal');
        const modalBody = document.getElementById('errorModalBody');
        
        if (modal && modalBody) {
            modalBody.textContent = message;
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else {
            // Fallback till alert om modalen inte kan hittas
            alert(message);
        }
    },
    
    showConfirm: function(message, yesCallback, noCallback = null) {
        const modal = document.getElementById('confirmModal');
        const modalBody = document.getElementById('confirmModalBody');
        const yesBtn = document.getElementById('confirmModalYesBtn');
        
        if (modal && modalBody && yesBtn) {
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
        const container = document.getElementById('saved-workouts-container');
        const noSavedWorkouts = document.getElementById('no-saved-workouts');
        
        if (!container || !noSavedWorkouts) {
            console.error("Could not find saved-workouts-container or no-saved-workouts element");
            return;
        }
        
        // Get saved workout days
        const savedWorkoutDays = this.getSavedWorkoutDays();
        
        // Show/hide "no saved workouts" message
        if (Object.keys(savedWorkoutDays).length === 0) {
            noSavedWorkouts.style.display = 'block';
            
            // Clear container except for noSavedWorkouts element
            Array.from(container.children).forEach(child => {
                if (child.id !== 'no-saved-workouts') {
                    child.remove();
                }
            });
            return;
        } else {
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
        
        // Render each workout day
        sortedDays.forEach(([day, workout]) => {
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
        this.renderSavedWorkouts();
        
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