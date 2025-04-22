// Save edited exercise - defined globally
function saveEditedExercise() {
    const editModal = document.getElementById('edit-exercise-modal');
    const exerciseItemIndex = editModal.dataset.exerciseItem;
    const exerciseContainer = document.getElementById('exercise-container');
    const exerciseItem = exerciseContainer.children[exerciseItemIndex];
    
    if (!exerciseItem) return;
    
    // Get edited values
    const editedExercise = {
        name: document.getElementById('edit-exercise-name').value,
        category: document.getElementById('edit-exercise-category').value,
        sets: parseInt(document.getElementById('edit-exercise-sets').value) || 0,
        reps: parseInt(document.getElementById('edit-exercise-reps').value) || 0,
        weight: parseFloat(document.getElementById('edit-exercise-weight').value) || 0,
        notes: document.getElementById('edit-exercise-notes').value.trim()
    };
    
    // Update exercise item with new values
    exerciseItem.dataset.exercise = JSON.stringify(editedExercise);
    
    // Update the displayed text
    let setsRepsText = `${editedExercise.sets} sets × ${editedExercise.reps} reps`;
    if (editedExercise.weight && editedExercise.weight > 0) {
        setsRepsText += ` × ${editedExercise.weight} kg`;
    }
    
    exerciseItem.querySelector('h6').textContent = editedExercise.name;
    exerciseItem.querySelector('.badge').textContent = editedExercise.category;
    exerciseItem.querySelector('small').textContent = setsRepsText;
    
    // Update or create notes div
    const notesDiv = exerciseItem.querySelector('.small');
    if (editedExercise.notes) {
        if (notesDiv) {
            notesDiv.textContent = editedExercise.notes;
        } else {
            const newNotesDiv = document.createElement('div');
            newNotesDiv.className = 'small text-muted';
            newNotesDiv.textContent = editedExercise.notes;
            exerciseItem.appendChild(newNotesDiv);
        }
    } else if (notesDiv) {
        notesDiv.remove();
    }
    
    // Close the modal
    const editExerciseModal = bootstrap.Modal.getInstance(document.getElementById('edit-exercise-modal'));
    editExerciseModal.hide();
}

// Function to edit schedule day - defined globally
function editScheduleDay(day) {
    // Spara dagen som ska redigeras i session storage
    sessionStorage.setItem('editScheduleDay', day);
    
    // Navigera till day.php
    window.location.href = 'day.php';
}

document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default
    document.getElementById('workout-date').valueAsDate = new Date();
    
    // Timer variables
    let timerInterval;
    let timerStartTime;
    let timerPausedTime = 0;
    let isTimerRunning = false;
    let isPaused = false;
    
    // DOM elements
    const startBtn = document.getElementById('start-btn');
    const pauseBtn = document.getElementById('pause-btn');
    const stopBtn = document.getElementById('stop-btn');
    const saveWorkoutBtn = document.getElementById('save-workout-btn');
    const timerDisplay = document.getElementById('workout-timer');
    const statusBadge = document.getElementById('status-badge');
    const activeWorkoutCard = document.getElementById('active-workout-card');
    const addExerciseBtn = document.getElementById('add-exercise-btn');
    const exerciseContainer = document.getElementById('exercise-container');
    const loadFromScheduleBtn = document.getElementById('load-from-schedule');
    
    // Create edit exercise modal
    createEditExerciseModal();
    
    // Clear any existing workout history on page load
    clearWorkoutHistory();
    
    // Force reload of workout templates
    localStorage.removeItem('workoutTemplates');
    
    // Helper function to generate a unique ID
    function generateUniqueId() {
        return Date.now() + Math.random().toString(36).substring(2, 9);
    }
    
    // Function to clear workout history
    function clearWorkoutHistory() {
        // Tog bort raden som rensar workoutLogs för att inte radera sparade träningar vid varje siduppdatering
        // console.log("Workout history clearing disabled");
    }
    
    // Exercise list from workout.js for select dropdown
    const exerciseOptions = [];
    
    // Add all exercises from exerciseDatabase in workout.js to the list
    for (const category in exerciseDatabase) {
        if (category !== 'Rest Day') {
            exerciseDatabase[category].forEach(exercise => {
                if (typeof exercise === 'object') {
                    exerciseOptions.push({
                        name: exercise.name,
                        category: category,
                        desc: exercise.desc || '',
                        link: exercise.link || '#'
                    });
                }
            });
        }
    }
    
    // Populate exercise selector
    function populateExerciseSelect() {
        const select = document.getElementById('exercise-name');
        
        // Group by category
        const categories = {};
        
        exerciseOptions.forEach(exercise => {
            if (!categories[exercise.category]) {
                categories[exercise.category] = [];
            }
            categories[exercise.category].push(exercise);
        });
        
        // Clear current options
        select.innerHTML = '<option value="">Select exercise...</option>';
        
        // Add categories with exercises
        for (const category in categories) {
            const optgroup = document.createElement('optgroup');
            optgroup.label = category;
            
            categories[category].forEach(exercise => {
                const option = document.createElement('option');
                option.value = exercise.name;
                option.textContent = exercise.name;
                option.dataset.category = exercise.category;
                option.dataset.desc = exercise.desc;
                option.dataset.link = exercise.link;
                optgroup.appendChild(option);
            });
            
            select.appendChild(optgroup);
        }
    }
    
    // Timer functions
    function startTimer() {
        if (!isTimerRunning) {
            timerStartTime = Date.now() - timerPausedTime;
            timerInterval = setInterval(updateTimer, 1000);
            isTimerRunning = true;
            isPaused = false;
            
            startBtn.disabled = true;
            pauseBtn.disabled = false;
            stopBtn.disabled = false;
            saveWorkoutBtn.disabled = true;
            
            statusBadge.textContent = 'In Progress';
            statusBadge.className = 'badge bg-success rounded-pill';
            activeWorkoutCard.classList.add('workout-in-progress');
        }
    }
    
    function pauseTimer() {
        if (isTimerRunning && !isPaused) {
            clearInterval(timerInterval);
            timerPausedTime = Date.now() - timerStartTime;
            isTimerRunning = false;
            isPaused = true;
            
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="lni lni-play"></i> Resume';
            pauseBtn.disabled = true;
            stopBtn.disabled = false;
            
            statusBadge.textContent = 'Paused';
            statusBadge.className = 'badge bg-warning rounded-pill';
            activeWorkoutCard.classList.remove('workout-in-progress');
        }
    }
    
    function stopTimer() {
        if (isTimerRunning || isPaused) {
            if (isTimerRunning) {
                clearInterval(timerInterval);
                timerPausedTime = Date.now() - timerStartTime;
            }
            
            isTimerRunning = false;
            
            startBtn.disabled = true;
            pauseBtn.disabled = true;
            stopBtn.disabled = true;
            saveWorkoutBtn.disabled = false;
            
            statusBadge.textContent = 'Completed';
            statusBadge.className = 'badge bg-danger rounded-pill';
            activeWorkoutCard.classList.remove('workout-in-progress');
        }
    }
    
    function updateTimer() {
        const elapsedTime = Date.now() - timerStartTime;
        timerDisplay.textContent = formatTime(elapsedTime);
    }
    
    function formatTime(time) {
        const seconds = Math.floor((time / 1000) % 60);
        const minutes = Math.floor((time / (1000 * 60)) % 60);
        const hours = Math.floor((time / (1000 * 60 * 60)));
        
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Add exercise to workout
    function addExerciseToWorkout(exercise) {
        const exerciseItem = document.createElement('div');
        exerciseItem.className = 'exercise-log p-3 bg-light rounded-3 mb-3';
        
        let setsRepsText = `${exercise.sets} sets × ${exercise.reps} reps`;
        if (exercise.weight && exercise.weight > 0) {
            setsRepsText += ` × ${exercise.weight} kg`;
        }
        
        // Skapa en array för individuella set om den inte redan finns
        if (!exercise.setDetails) {
            exercise.setDetails = [];
            // Förbered tomma set
            for (let i = 0; i < exercise.sets; i++) {
                exercise.setDetails.push({
                    setNumber: i + 1,
                    actualReps: 0,
                    actualWeight: 0,
                    completed: false
                });
            }
        }
        
        exerciseItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h6 class="mb-0 fw-bold">${exercise.name}</h6>
                    <span class="badge bg-primary">${exercise.category}</span>
                    <small class="text-muted">${setsRepsText}</small>
                </div>
                <div>
                    <button class="btn btn-sm btn-link text-primary p-0 me-3 edit-exercise">
                        <i class="lni lni-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-link text-danger p-0 remove-exercise">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
            </div>
            ${exercise.notes ? `<div class="small text-muted mb-3">${exercise.notes}</div>` : ''}
            
            <div class="set-tracking mt-3">
                <div class="set-tracking-header mb-2">
                    <span class="fw-bold">Track your sets</span>
                    <button class="btn btn-sm btn-link text-primary add-set">
                        <i class="lni lni-plus"></i> Add set
                    </button>
                </div>
                <div class="set-tracking-table">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Set</th>
                                <th>Reps</th>
                                <th>Weight (kg)</th>
                                <th>Done</th>
                            </tr>
                        </thead>
                        <tbody class="set-details">
                            ${exercise.setDetails.map(set => `
                                <tr data-set="${set.setNumber}">
                                    <td>${set.setNumber}</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm set-reps" 
                                               value="${set.actualReps || ''}" 
                                               placeholder="${exercise.reps}">
                                    </td>
                                    <td>
                                        <input type="number" step="0.5" class="form-control form-control-sm set-weight" 
                                               value="${set.actualWeight || ''}" 
                                               placeholder="${exercise.weight || ''}">
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input set-completed" type="checkbox" 
                                                   ${set.completed ? 'checked' : ''}>
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
        
        exerciseContainer.appendChild(exerciseItem);
        
        // Spara original-data för senare användning
        exerciseItem.dataset.exercise = JSON.stringify(exercise);
        
        // Add listener to remove the exercise
        exerciseItem.querySelector('.remove-exercise').addEventListener('click', function() {
            exerciseItem.remove();
        });
        
        // Add listener to edit the exercise
        exerciseItem.querySelector('.edit-exercise').addEventListener('click', function() {
            openEditExerciseModal(exerciseItem);
        });
        
        // Add listener to add new set
        exerciseItem.querySelector('.add-set').addEventListener('click', function() {
            const setDetailsElement = exerciseItem.querySelector('.set-details');
            const exercise = JSON.parse(exerciseItem.dataset.exercise);
            const newSetNumber = exercise.setDetails.length + 1;
            
            // Lägg till ett nytt set i exercise object
            exercise.setDetails.push({
                setNumber: newSetNumber,
                actualReps: 0,
                actualWeight: 0,
                completed: false
            });
            
            // Uppdatera dataset
            exerciseItem.dataset.exercise = JSON.stringify(exercise);
            
            // Skapa ny rad för nya setet
            const newRow = document.createElement('tr');
            newRow.dataset.set = newSetNumber;
            newRow.innerHTML = `
                <td>${newSetNumber}</td>
                <td>
                    <input type="number" class="form-control form-control-sm set-reps" 
                           placeholder="${exercise.reps}">
                </td>
                <td>
                    <input type="number" step="0.5" class="form-control form-control-sm set-weight" 
                           placeholder="${exercise.weight || ''}">
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input set-completed" type="checkbox">
                    </div>
                </td>
            `;
            
            setDetailsElement.appendChild(newRow);
            addSetInputListeners(newRow, exerciseItem);
        });
        
        // Add listeners to set inputs
        const setRows = exerciseItem.querySelectorAll('.set-details tr');
        setRows.forEach(row => {
            addSetInputListeners(row, exerciseItem);
        });
    }
    
    // Helper function to add input listeners to set rows
    function addSetInputListeners(row, exerciseItem) {
        const setNumber = parseInt(row.dataset.set);
        const repsInput = row.querySelector('.set-reps');
        const weightInput = row.querySelector('.set-weight');
        const completedCheck = row.querySelector('.set-completed');
        
        // Listen for changes on the inputs
        [repsInput, weightInput, completedCheck].forEach(element => {
            element.addEventListener('change', function() {
                const exercise = JSON.parse(exerciseItem.dataset.exercise);
                const setIndex = setNumber - 1;
                
                if (setIndex >= 0 && setIndex < exercise.setDetails.length) {
                    exercise.setDetails[setIndex].actualReps = parseInt(repsInput.value) || 0;
                    exercise.setDetails[setIndex].actualWeight = parseFloat(weightInput.value) || 0;
                    exercise.setDetails[setIndex].completed = completedCheck.checked;
                    
                    // Uppdatera dataset
                    exerciseItem.dataset.exercise = JSON.stringify(exercise);
                }
            });
        });
    }
    
    // Open modal to edit an exercise
    function openEditExerciseModal(exerciseItem) {
        const exercise = JSON.parse(exerciseItem.dataset.exercise);
        
        // Populate modal with exercise data
        document.getElementById('edit-exercise-name').value = exercise.name;
        document.getElementById('edit-exercise-category').value = exercise.category;
        document.getElementById('edit-exercise-sets').value = exercise.sets;
        document.getElementById('edit-exercise-reps').value = exercise.reps;
        document.getElementById('edit-exercise-weight').value = exercise.weight || '';
        document.getElementById('edit-exercise-notes').value = exercise.notes || '';
        
        // Set the reference to the exercise item being edited
        document.getElementById('edit-exercise-modal').dataset.editingExercise = exerciseItem.dataset.exercise;
        document.getElementById('edit-exercise-modal').dataset.exerciseItem = Array.from(exerciseContainer.children).indexOf(exerciseItem);
        
        // Show the modal
        const editExerciseModal = new bootstrap.Modal(document.getElementById('edit-exercise-modal'));
        editExerciseModal.show();
    }
    
    // Save workout
    function saveWorkout() {
        const workoutName = document.getElementById('workout-name').value.trim() || 'Unnamed Workout';
        const workoutDate = document.getElementById('workout-date').value;
        const workoutLocation = document.getElementById('workout-location').value.trim();
        const workoutNotes = document.getElementById('workout-notes').value.trim();
        const workoutDuration = timerDisplay.textContent;
        
        // Collect exercises
        const exercises = [];
        document.querySelectorAll('.exercise-log').forEach(item => {
            // Hämta den kompletta övningsdatan från dataset (inkl. setdetaljer)
            const exerciseData = JSON.parse(item.dataset.exercise);
            exercises.push(exerciseData);
        });
        
        // Create workout object
        const workout = {
            id: Date.now(), // Unique ID based on timestamp
            name: workoutName,
            date: workoutDate,
            location: workoutLocation,
            duration: workoutDuration,
            notes: workoutNotes,
            exercises: exercises,
            startTime: new Date(timerStartTime).toISOString(),
            endTime: new Date(timerStartTime + timerPausedTime).toISOString()
        };
        
        // Get existing saved workouts using the user-specific function
        let savedWorkouts = getUserWorkouts();
        savedWorkouts.push(workout);
        
        // Save back using the user-specific function
        saveUserWorkouts(savedWorkouts);
        
        // Update UI
        loadWorkoutHistory();
        loadWorkoutTemplates();
        
        // Create a post in social feed to share the workout if checkbox is checked
        const shareToSocial = document.getElementById('share-to-social').checked;
        if (shareToSocial) {
            shareWorkoutToSocialFeed(workout);
        }
        
        // Reset the form
        resetWorkoutForm();
        
        // Show confirmation
        alert('Workout saved successfully!');
    }
    
    // Share workout to social feed
    function shareWorkoutToSocialFeed(workout) {
        // Create a nicely formatted message
        let exerciseList = '';
        if (workout.exercises.length > 0) {
            exerciseList = workout.exercises.map(ex => {
                let exerciseText = `${ex.name}`;
                if (ex.sets && ex.reps) {
                    exerciseText += ` (${ex.sets} sets × ${ex.reps} reps`;
                    if (ex.weight) {
                        exerciseText += ` × ${ex.weight} kg`;
                    }
                    exerciseText += `)`;
                }
                return exerciseText;
            }).join(', ');
        }
        
        let message = `I just completed a workout: "${workout.name}" 💪\n\n`;
        message += `Duration: ${workout.duration}\n`;
        
        if (workout.location) {
            message += `Location: ${workout.location}\n`;
        }
        
        message += `\nExercises: ${exerciseList}`;
        
        if (workout.notes) {
            message += `\n\nNotes: ${workout.notes}`;
        }
        
        message += `\n\n#workout #fitness #gymlog`;
        
        // Send the post to the API
        const formData = new FormData();
        formData.append('content', message);
        formData.append('post_type', 'workout');
        formData.append('workout_id', workout.id); // Include the workout ID
        
        fetch('api/social_api.php?action=create_post', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Workout shared to social feed successfully!');
            } else {
                console.error('Failed to share workout to social feed:', data.message);
            }
        })
        .catch(error => {
            console.error('Error sharing workout to social feed:', error);
        });
    }
    
    // Reset the form after a workout has been saved
    function resetWorkoutForm() {
        document.getElementById('workout-name').value = '';
        document.getElementById('workout-date').valueAsDate = new Date();
        document.getElementById('workout-location').value = '';
        document.getElementById('workout-notes').value = '';
        exerciseContainer.innerHTML = '';
        
        timerDisplay.textContent = '00:00:00';
        timerPausedTime = 0;
        
        startBtn.disabled = false;
        startBtn.innerHTML = '<i class="lni lni-play"></i> Start';
        pauseBtn.disabled = true;
        stopBtn.disabled = true;
        saveWorkoutBtn.disabled = true;
        
        statusBadge.textContent = 'Ready to Start';
        statusBadge.className = 'badge bg-primary rounded-pill';
    }
    
    // Handle workout history
    function loadWorkoutHistory() {
        const historyContainer = document.getElementById('workout-history-container');
        const noHistory = document.getElementById('no-history');
        
        // Get saved workouts using the user-specific function
        const savedWorkouts = getUserWorkouts();
        
        if (savedWorkouts.length === 0) {
            noHistory.style.display = 'block';
            historyContainer.innerHTML = '';
            historyContainer.appendChild(noHistory);
            return;
        }
        
        // Sort workouts with newest first
        savedWorkouts.sort((a, b) => new Date(b.date) - new Date(a.date));
        
        // Hide no-history message
        noHistory.style.display = 'none';
        
        // Clear history container and create new structure
        historyContainer.innerHTML = '';
        
        savedWorkouts.forEach(workout => {
            const historyItem = document.createElement('div');
            historyItem.className = 'col-md-6 col-lg-4 mb-4';
            
            // Format date
            const workoutDate = new Date(workout.date);
            const formattedDate = workoutDate.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            historyItem.innerHTML = `
                <div class="card shadow border-0 rounded-4 workout-card" data-workout-id="${workout.id}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title fw-bold mb-0">${workout.name}</h4>
                            <span class="badge bg-primary rounded-pill">${workout.duration}</span>
                        </div>
                        <div class="mb-3">
                            <div class="small text-muted">
                                <i class="lni lni-calendar me-1"></i> ${formattedDate}
                            </div>
                            ${workout.location ? 
                                `<div class="small text-muted">
                                    <i class="lni lni-map-marker me-1"></i> ${workout.location}
                                 </div>` : ''}
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="badge bg-light text-dark">${workout.exercises.length} exercises</span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-link p-0 text-primary view-details"
                                        data-workout-id="${workout.id}">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-sm btn-outline-primary use-template"
                                    data-workout-id="${workout.id}">
                                <i class="lni lni-reload"></i> Use as Template
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-workout"
                                    data-workout-id="${workout.id}">
                                <i class="lni lni-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            historyContainer.appendChild(historyItem);
            
            // Add event listeners for buttons
            const viewDetailsBtn = historyItem.querySelector('.view-details');
            const useTemplateBtn = historyItem.querySelector('.use-template');
            const deleteWorkoutBtn = historyItem.querySelector('.delete-workout');
            
            viewDetailsBtn.addEventListener('click', () => showWorkoutDetails(workout.id));
            useTemplateBtn.addEventListener('click', () => useWorkoutAsTemplate(workout.id));
            deleteWorkoutBtn.addEventListener('click', () => deleteWorkout(workout.id));
        });
    }
    
    // Show workout details in a modal
    function showWorkoutDetails(workoutId) {
        const savedWorkouts = getUserWorkouts();
        const workout = savedWorkouts.find(w => w.id === workoutId);
        
        if (!workout) return;
        
        const detailsContent = document.getElementById('workout-details-content');
        
        // Format date
        const workoutDate = new Date(workout.date);
        const formattedDate = workoutDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        let exercisesHtml = '';
        
        if (workout.exercises.length > 0) {
            exercisesHtml = '<div class="mt-4"><h5 class="mb-3">Exercises</h5><div class="list-group">';
            
            workout.exercises.forEach(exercise => {
                let exerciseDetails = `${exercise.sets} sets × ${exercise.reps} reps`;
                if (exercise.weight) {
                    exerciseDetails += ` × ${exercise.weight} kg`;
                }
                
                // Skapa HTML för setdetaljer
                let setDetailsHtml = '';
                if (exercise.setDetails && exercise.setDetails.length > 0) {
                    setDetailsHtml = `
                        <div class="mt-2">
                            <div class="fw-bold text-muted small mb-1">Set Details</div>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="small">Set</th>
                                        <th class="small">Reps</th>
                                        <th class="small">Weight (kg)</th>
                                        <th class="small">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${exercise.setDetails.map(set => `
                                        <tr>
                                            <td class="small">${set.setNumber}</td>
                                            <td class="small">${set.actualReps || '-'}</td>
                                            <td class="small">${set.actualWeight || '-'}</td>
                                            <td class="small">
                                                ${set.completed ? 
                                                    '<span class="badge bg-success">Completed</span>' : 
                                                    '<span class="badge bg-secondary">Not completed</span>'}
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                }
                
                exercisesHtml += `
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">${exercise.name}</h6>
                            <span class="badge bg-primary">${exercise.category}</span>
                        </div>
                        <div class="small">${exerciseDetails}</div>
                        ${exercise.notes ? `<div class="small text-muted mt-1">${exercise.notes}</div>` : ''}
                        ${setDetailsHtml}
                    </div>
                `;
            });
            
            exercisesHtml += '</div></div>';
        }
        
        // Show workout details in the modal
        detailsContent.innerHTML = `
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="card-title fw-bold">${workout.name}</h4>
                    <div class="text-muted mb-2">
                        <i class="lni lni-calendar me-1"></i> ${formattedDate}
                    </div>
                    ${workout.location ? 
                        `<div class="text-muted mb-2">
                            <i class="lni lni-map-marker me-1"></i> ${workout.location}
                         </div>` : ''}
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column align-items-md-end">
                        <div class="badge bg-primary rounded-pill mb-2 px-3 py-2">
                            <i class="lni lni-timer me-1"></i> ${workout.duration}
                        </div>
                        <div class="small text-muted">
                            <strong>Started:</strong> ${new Date(workout.startTime).toLocaleTimeString('en-US')}
                        </div>
                        <div class="small text-muted">
                            <strong>Finished:</strong> ${new Date(workout.endTime).toLocaleTimeString('en-US')}
                        </div>
                    </div>
                </div>
            </div>
            
            ${workout.notes ? 
                `<div class="mb-4">
                    <h5 class="mb-2">Notes</h5>
                    <div class="p-3 bg-light rounded-3">${workout.notes}</div>
                 </div>` : ''}
            
            ${exercisesHtml}
        `;
        
        // Show the modal
        const workoutDetailsModal = new bootstrap.Modal(document.getElementById('workoutDetailsModal'));
        workoutDetailsModal.show();
    }
    
    // Use a saved workout as a template
    function useWorkoutAsTemplate(workoutId) {
        let workout;
        
        // Try to find the workout in the history first
        const savedWorkouts = getUserWorkouts();
        workout = savedWorkouts.find(w => w.id === workoutId);
        
        // If not found in history, check templates
        if (!workout) {
            const templates = getUserTemplates();
            workout = templates.find(w => w.id === workoutId);
        }
        
        if (!workout) return;
        
        // Reset the form first
        resetWorkoutForm();
        
        // Fill the form with data from the workout
        document.getElementById('workout-name').value = workout.name;
        document.getElementById('workout-location').value = workout.location || '';
        document.getElementById('workout-notes').value = workout.notes || '';
        
        // Add exercises
        exerciseContainer.innerHTML = '';
        workout.exercises.forEach(exercise => {
            addExerciseToWorkout(exercise);
        });
        
        // Enable start button and highlight it
        startBtn.disabled = false;
        startBtn.classList.add('btn-pulse');
        setTimeout(() => startBtn.classList.remove('btn-pulse'), 2000);
        
        // Visa och aktivera timerkontrollerna
        document.querySelector('.timer-controls').classList.remove('d-none');
        
        // Show the workout form
        document.getElementById('workout-form-container').classList.remove('d-none');
        
        // Scroll up to the form
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    
    // Delete a workout
    function deleteWorkout(workoutId) {
        if (confirm('Are you sure you want to delete this workout?')) {
            // Get user's workouts
            let savedWorkouts = getUserWorkouts();
            savedWorkouts = savedWorkouts.filter(w => w.id !== workoutId);
            // Save user workouts
            saveUserWorkouts(savedWorkouts);
            
            // Ta bort från DOM
            const workoutElement = document.querySelector(`.workout-card[data-workout-id="${workoutId}"]`);
            if (workoutElement) {
                const parentElement = workoutElement.closest('.col-md-6.col-lg-4.mb-4');
                if (parentElement) {
                    parentElement.remove();
                }
            }
            
            // Kontrollera om vi behöver visa "no history" meddelandet
            if (savedWorkouts.length === 0) {
                const historyContainer = document.getElementById('workout-history-container');
                const noHistory = document.getElementById('no-history');
                
                noHistory.style.display = 'block';
                historyContainer.innerHTML = '';
                historyContainer.appendChild(noHistory);
            }
        }
    }
    
    // Workout templates
    function loadWorkoutTemplates() {
        // Get templates for current user
        const templates = getUserTemplates();
        const templateSection = document.getElementById('workoutTemplates');
        
        if (!templateSection) return;
        
        templateSection.innerHTML = '';
        
        if (templates.length === 0) {
            templateSection.innerHTML = '<p class="text-center py-3">No workout templates available. Add your first workout template!</p>';
            return;
        }
        
        templates.forEach(template => {
            const templateCard = document.createElement('div');
            templateCard.className = 'card mb-3';
            
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';
            
            const title = document.createElement('h5');
            title.className = 'card-title';
            title.textContent = template.name;
            
            const exerciseList = document.createElement('ul');
            exerciseList.className = 'list-group list-group-flush mb-3';
            
            template.exercises.forEach(exercise => {
                const exerciseItem = document.createElement('li');
                exerciseItem.className = 'list-group-item';
                exerciseItem.textContent = `${exercise.name} - ${exercise.sets} sets x ${exercise.reps} reps`;
                exerciseList.appendChild(exerciseItem);
            });
            
            const useTemplateBtn = document.createElement('button');
            useTemplateBtn.className = 'btn btn-primary me-2';
            useTemplateBtn.textContent = 'Use Template';
            useTemplateBtn.dataset.templateId = template.id;
            useTemplateBtn.addEventListener('click', function() {
                useWorkoutAsTemplate(template.id);
            });
            
            const deleteTemplateBtn = document.createElement('button');
            deleteTemplateBtn.className = 'btn btn-danger';
            deleteTemplateBtn.textContent = 'Delete';
            deleteTemplateBtn.dataset.templateId = template.id;
            deleteTemplateBtn.addEventListener('click', function() {
                deleteWorkoutTemplate(template.id);
            });
            
            cardBody.appendChild(title);
            cardBody.appendChild(exerciseList);
            cardBody.appendChild(useTemplateBtn);
            cardBody.appendChild(deleteTemplateBtn);
            
            templateCard.appendChild(cardBody);
            templateSection.appendChild(templateCard);
        });
    }
    
    // Handle training schedule
    function openScheduleModal() {
        const scheduleList = document.getElementById('schedule-days-list');
        scheduleList.innerHTML = '';
        
        // Get saved training days from localStorage (should be created by day.php)
        const savedDays = getSavedWorkoutDays();
        
        if (Object.keys(savedDays).length === 0) {
            scheduleList.innerHTML = `
                <div class="alert alert-info">
                    <i class="lni lni-information-circle me-2"></i>
                    No saved training days found. Go to Training Schedule to create and save workout days.
                </div>
            `;
        } else {
            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            
            days.forEach(day => {
                const dayLower = day.toLowerCase();
                if (savedDays[dayLower]) {
                    const workoutPlan = savedDays[dayLower];
                    
                    const item = document.createElement('button');
                    item.className = 'list-group-item list-group-item-action';
                    item.type = 'button';
                    
                    item.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">${day}</h6>
                                <div class="small text-muted">
                                    ${workoutPlan.focus ? workoutPlan.focus.join(', ') : 'No focus selected'}
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-primary me-2 edit-day-btn" data-day="${dayLower}" 
                                    onclick="event.stopPropagation();">
                                    <i class="lni lni-pencil"></i>
                                </button>
                                <span class="badge bg-primary rounded-pill">
                                    ${workoutPlan.exercises ? workoutPlan.exercises.length : 0} exercises
                                </span>
                            </div>
                        </div>
                    `;
                    
                    scheduleList.appendChild(item);
                    
                    // Add click event
                    item.addEventListener('click', () => {
                        loadScheduleDay(dayLower, workoutPlan);
                        bootstrap.Modal.getInstance(document.getElementById('scheduleModal')).hide();
                    });
                    
                    // Add edit button click event
                    const editBtn = item.querySelector('.edit-day-btn');
                    editBtn.addEventListener('click', () => {
                        editScheduleDay(dayLower);
                        bootstrap.Modal.getInstance(document.getElementById('scheduleModal')).hide();
                    });
                }
            });
        }
        
        // Show the modal
        const scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));
        scheduleModal.show();
    }
    
    // Load training day from schedule
    function loadScheduleDay(day, workoutPlan) {
        if (!workoutPlan || !workoutPlan.exercises || workoutPlan.exercises.length === 0) {
            alert('This training day has no exercises.');
            return;
        }
        
        // Reset the form first
        resetWorkoutForm();
        
        // Fill in basic information
        document.getElementById('workout-name').value = `${day.charAt(0).toUpperCase() + day.slice(1)} Workout`;
        
        // Add exercises from the schedule
        exerciseContainer.innerHTML = '';
        
        workoutPlan.exercises.forEach(scheduleExercise => {
            // Find exercise category
            let category = '';
            for (const cat in exerciseDatabase) {
                const found = exerciseDatabase[cat].find(ex => 
                    typeof ex === 'object' && ex.name === scheduleExercise.name
                );
                if (found) {
                    category = cat;
                    break;
                }
            }
            
            // Create default values for sets and reps
            const exercise = {
                name: scheduleExercise.name,
                category: category || 'Other',
                sets: 3,
                reps: 10,
                weight: 0,
                notes: ''
            };
            
            addExerciseToWorkout(exercise);
        });
    }
    
    // Add pulse animation style to the head
    const style = document.createElement('style');
    style.textContent = `
        .btn-pulse {
            animation: button-pulse 1.5s ease-in-out;
        }
        @keyframes button-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); box-shadow: 0 0 15px rgba(13, 110, 253, 0.5); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
    
    // Event listeners
    startBtn.addEventListener('click', startTimer);
    pauseBtn.addEventListener('click', pauseTimer);
    stopBtn.addEventListener('click', stopTimer);
    saveWorkoutBtn.addEventListener('click', saveWorkout);
    loadFromScheduleBtn.addEventListener('click', openScheduleModal);
    
    // Modal for adding exercise
    const addExerciseModal = new bootstrap.Modal(document.getElementById('addExerciseModal'));
    
    // Hantera byte mellan fördefinierade och anpassade övningar
    document.querySelectorAll('input[name="exercise-type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const presetSection = document.getElementById('preset-exercise-section');
            const customSection = document.getElementById('custom-exercise-section');
            
            if (this.value === 'preset') {
                presetSection.style.display = 'block';
                customSection.style.display = 'none';
            } else {
                presetSection.style.display = 'none';
                customSection.style.display = 'block';
            }
        });
    });
    
    addExerciseBtn.addEventListener('click', function() {
        populateExerciseSelect();
        
        // Återställ radioknapparna
        document.getElementById('exercise-type-preset').checked = true;
        document.getElementById('preset-exercise-section').style.display = 'block';
        document.getElementById('custom-exercise-section').style.display = 'none';
        
        // Rensa alla fält
        document.getElementById('custom-exercise-name').value = '';
        document.getElementById('custom-exercise-category').value = '';
        document.getElementById('exercise-sets').value = '3';
        document.getElementById('exercise-reps').value = '10';
        document.getElementById('exercise-weight').value = '';
        document.getElementById('exercise-notes').value = '';
        
        addExerciseModal.show();
    });
    
    document.getElementById('save-exercise-btn').addEventListener('click', function() {
        let exercise = {};
        const isCustomExercise = document.getElementById('exercise-type-custom').checked;
        
        if (isCustomExercise) {
            const customName = document.getElementById('custom-exercise-name').value.trim();
            const customCategory = document.getElementById('custom-exercise-category').value;
            
            if (!customName) {
                alert('Please enter an exercise name.');
                return;
            }
            
            if (!customCategory) {
                alert('Please select a category.');
                return;
            }
            
            exercise = {
                name: customName,
                category: customCategory,
                sets: parseInt(document.getElementById('exercise-sets').value) || 0,
                reps: parseInt(document.getElementById('exercise-reps').value) || 0,
                weight: parseFloat(document.getElementById('exercise-weight').value) || 0,
                notes: document.getElementById('exercise-notes').value.trim()
            };
        } else {
            const exerciseSelect = document.getElementById('exercise-name');
            const selectedOption = exerciseSelect.options[exerciseSelect.selectedIndex];
            
            if (!exerciseSelect.value) {
                alert('Please select an exercise first.');
                return;
            }
            
            exercise = {
                name: exerciseSelect.value,
                category: selectedOption.dataset.category || 'Other',
                sets: parseInt(document.getElementById('exercise-sets').value) || 0,
                reps: parseInt(document.getElementById('exercise-reps').value) || 0,
                weight: parseFloat(document.getElementById('exercise-weight').value) || 0,
                notes: document.getElementById('exercise-notes').value.trim()
            };
        }
        
        addExerciseToWorkout(exercise);
        addExerciseModal.hide();
    });
    
    // Load workout history and templates when the page loads
    loadWorkoutHistory();
    loadWorkoutTemplates();
});

// Create edit exercise modal - defined globally
function createEditExerciseModal() {
    // Check if the modal already exists
    if (document.getElementById('edit-exercise-modal')) return;
    
    // Create the modal structure
    const modalHTML = `
    <div class="modal fade" id="edit-exercise-modal" tabindex="-1" aria-labelledby="editExerciseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExerciseModalLabel">Redigera övning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-exercise-form">
                        <div class="mb-3">
                            <label for="edit-exercise-name" class="form-label">Övningsnamn</label>
                            <input type="text" class="form-control" id="edit-exercise-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-exercise-category" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="edit-exercise-category">
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="edit-exercise-sets" class="form-label">Sets</label>
                                <input type="number" class="form-control" id="edit-exercise-sets" min="1" value="3">
                            </div>
                            <div class="col-4">
                                <label for="edit-exercise-reps" class="form-label">Reps</label>
                                <input type="number" class="form-control" id="edit-exercise-reps" min="1" value="10">
                            </div>
                            <div class="col-4">
                                <label for="edit-exercise-weight" class="form-label">Vikt (kg)</label>
                                <input type="number" class="form-control" id="edit-exercise-weight" min="0" step="0.5">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-exercise-notes" class="form-label">Anteckningar</label>
                            <textarea class="form-control" id="edit-exercise-notes" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Avbryt</button>
                    <button type="button" class="btn btn-primary" id="save-edited-exercise-btn">Spara ändringar</button>
                </div>
            </div>
        </div>
    </div>
    `;
    
    // Append the modal to the body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Add event listener for the save button
    document.getElementById('save-edited-exercise-btn').addEventListener('click', saveEditedExercise);
}

// Function to handle user specific data storage
function getUserId() {
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
}

// Get workouts for current user
function getUserWorkouts() {
    const userId = getUserId();
    return JSON.parse(localStorage.getItem(`workoutLogs_${userId}`)) || [];
}

// Save workouts for current user
function saveUserWorkouts(workouts) {
    const userId = getUserId();
    localStorage.setItem(`workoutLogs_${userId}`, JSON.stringify(workouts));
}

// Get templates for current user
function getUserTemplates() {
    const userId = getUserId();
    return JSON.parse(localStorage.getItem(`workoutTemplates_${userId}`)) || [];
}

// Save templates for current user
function saveUserTemplates(templates) {
    const userId = getUserId();
    localStorage.setItem(`workoutTemplates_${userId}`, JSON.stringify(templates));
}

// Delete a workout template
function deleteWorkoutTemplate(templateId) {
    if (confirm('Are you sure you want to delete this workout template?')) {
        // Hämta användarens mallar
        let templates = getUserTemplates();
        
        // Filtrera bort den valda mallen
        templates = templates.filter(t => t.id !== templateId);
        
        // Spara den uppdaterade listan
        saveUserTemplates(templates);
        
        // Uppdatera UI
        loadWorkoutTemplates();
    }
}

// Get workout days schedule for current user
function getSavedWorkoutDays() {
    const userId = getUserId();
    return JSON.parse(localStorage.getItem(`savedWorkoutDays_${userId}`)) || {};
} 