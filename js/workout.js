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

// Funktioner för att hantera sparade träningsdagar
function saveWorkout(day) {
    // Samla in all data från den valda dagen
    const selectedPartsContainer = document.querySelector(`#selected-parts-${day} .d-flex`);
    const selectedExercisesContainer = document.querySelector(`#selected-exercises-${day} .selected-exercises-container`);
    const notes = document.querySelector(`#notes-${day}`).value;
    
    // Kontrollera om det finns några valda muskelgrupper eller övningar
    if (selectedPartsContainer.children.length === 0 || selectedExercisesContainer.children.length === 0) {
        alert("Please add at least one body part and exercise before saving.");
        return;
    }
    
    // Samla muskelgrupper
    const bodyParts = [];
    Array.from(selectedPartsContainer.children).forEach(part => {
        bodyParts.push(part.textContent.trim().replace('×', '').trim());
    });
    
    // Samla övningar och detaljer
    const exercises = [];
    Array.from(selectedExercisesContainer.children).forEach(exercise => {
        const name = exercise.querySelector('h6').textContent;
        const sets = exercise.querySelector('input[placeholder="Sets"]').value || '';
        const reps = exercise.querySelector('input[placeholder="Reps"]').value || '';
        const weight = exercise.querySelector('input[placeholder="Weight"]').value || '';
        
        const exerciseData = {
            name: name,
            sets: sets,
            reps: reps,
            weight: weight
        };
        
        exercises.push(exerciseData);
    });
    
    // Formatera dagnamnet korrekt
    const dayFormatted = day.charAt(0).toUpperCase() + day.slice(1).toLowerCase();
    
    // Skapa workout-objekt
    const workout = {
        day: dayFormatted,
        date: new Date().toISOString(),
        bodyParts: bodyParts,
        exercises: exercises,
        notes: notes
    };
    
    // Hämta befintliga workouts från localStorage
    let savedWorkouts = JSON.parse(localStorage.getItem('savedWorkouts')) || [];
    
    // Lägg till eller uppdatera workout
    const existingIndex = savedWorkouts.findIndex(w => w.day.toLowerCase() === day.toLowerCase());
    if (existingIndex !== -1) {
        savedWorkouts[existingIndex] = workout;
    } else {
        savedWorkouts.push(workout);
    }
    
    // Spara till localStorage
    localStorage.setItem('savedWorkouts', JSON.stringify(savedWorkouts));
    
    // Uppdatera UI
    renderSavedWorkouts();
    
    // Visa bekräftelse
    alert(`Workout for ${dayFormatted} has been saved!`);
}

function loadWorkout(day) {
    // Hämta befintliga workouts från localStorage
    const savedWorkouts = JSON.parse(localStorage.getItem('savedWorkouts')) || [];
    const workout = savedWorkouts.find(w => w.day.toLowerCase() === day.toLowerCase());
    
    if (!workout) {
        alert(`No saved workout found for ${day}.`);
        return;
    }
    
    const dayLower = day.toLowerCase();
    
    // Rensa befintliga val
    document.querySelector(`#selected-parts-${dayLower} .d-flex`).innerHTML = '';
    document.querySelector(`#selected-exercises-${dayLower} .selected-exercises-container`).innerHTML = '';
    document.querySelector(`#notes-${dayLower}`).value = workout.notes || '';
    
    // Avmarkera alla checkboxar
    document.querySelectorAll(`input[id^="${dayLower}-"]`).forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Markera de valda muskelgrupperna
    workout.bodyParts.forEach(part => {
        const checkbox = document.getElementById(`${dayLower}-${part.toLowerCase().replace(' ', '-')}`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });
    
    // Uppdatera UI för valda muskelgrupper
    updateWorkoutFocus(dayLower);
    
    // Lägg till övningarna
    workout.exercises.forEach(exercise => {
        // Hitta eventuell matchande muskelgrupp för övningen
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
        
        if (!matchedBodyPart && workout.bodyParts.length > 0) {
            matchedBodyPart = workout.bodyParts[0];
        }
        
        // Hitta övningsinformation, om den finns i databasen
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
        
        // Skapa övningselementet
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
    
    // Visa add-exercise-knappen
    document.querySelector(`#selected-exercises-${dayLower} .add-exercise-btn`).style.display = 'inline-flex';
    
    // Scrolla till dagen
    document.querySelector(`#dropdown-${dayLower}`).scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function renderSavedWorkouts() {
    const container = document.getElementById('saved-workouts-container');
    const noSavedWorkouts = document.getElementById('no-saved-workouts');
    
    // Hämta sparade workouts
    const savedWorkouts = JSON.parse(localStorage.getItem('savedWorkouts')) || [];
    
    // Visa/dölj "inga sparade workouts" meddelande
    if (savedWorkouts.length === 0) {
        noSavedWorkouts.style.display = 'block';
        return;
    } else {
        noSavedWorkouts.style.display = 'none';
    }
    
    // Rensa container utom noSavedWorkouts-elementet
    Array.from(container.children).forEach(child => {
        if (child.id !== 'no-saved-workouts') {
            child.remove();
        }
    });
    
    // Sortera workouts efter dag (måndag först, etc.)
    const dayOrder = {
        'monday': 1, 'tuesday': 2, 'wednesday': 3, 'thursday': 4, 
        'friday': 5, 'saturday': 6, 'sunday': 7
    };
    
    savedWorkouts.sort((a, b) => {
        return dayOrder[a.day.toLowerCase()] - dayOrder[b.day.toLowerCase()];
    });
    
    // Rendera varje workout
    savedWorkouts.forEach(workout => {
        const workoutCard = document.createElement('div');
        workoutCard.className = 'col-md-6 col-lg-4 mb-4';
        workoutCard.innerHTML = `
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title h5 fw-bold mb-0">${workout.day}</h3>
                        <div>
                            <button class="btn btn-sm btn-outline-success me-2" 
                                    onclick="loadWorkout('${workout.day}')" 
                                    title="Load workout">
                                <i class="lni lni-reload"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary me-2" 
                                    onclick="editWorkout('${workout.day}')" 
                                    title="Edit workout">
                                <i class="lni lni-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteWorkout('${workout.day}')" 
                                    title="Delete workout">
                                <i class="lni lni-trash-can"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            ${workout.bodyParts.map(part => 
                                `<span class="badge bg-light text-primary">${part}</span>`
                            ).join('')}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted small text-uppercase fw-bold">Övningar</h6>
                        <ul class="list-group list-group-flush">
                            ${workout.exercises.map(exercise => `
                                <li class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-medium">${exercise.name}</span>
                                        <span class="text-muted small">
                                            ${exercise.sets ? exercise.sets + ' sets' : ''}
                                            ${exercise.reps ? ' × ' + exercise.reps + ' reps' : ''}
                                            ${exercise.weight ? ' × ' + exercise.weight : ''}
                                        </span>
                                    </div>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                    
                    ${workout.notes ? `
                        <div class="mt-3">
                            <h6 class="text-muted small text-uppercase fw-bold">Anteckningar</h6>
                            <p class="mb-0 text-muted small">${workout.notes}</p>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        container.appendChild(workoutCard);
    });
}

function editWorkout(day) {
    // Hitta motsvarande dag i UI och scrolla till den
    const dayElements = document.querySelectorAll('.card-title.h4');
    let foundElement = null;
    
    dayElements.forEach(element => {
        if (element.textContent.trim().toLowerCase() === day.toLowerCase()) {
            foundElement = element;
        }
    });
    
    if (foundElement) {
        foundElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Markera kortet för att dra uppmärksamhet till det
        const card = foundElement.closest('.card');
        card.classList.add('border-primary');
        setTimeout(() => {
            card.classList.remove('border-primary');
        }, 2000);
    }
}

function deleteWorkout(day) {
    if (confirm(`Are you sure you want to delete the workout for ${day}?`)) {
        // Hämta befintliga workouts från localStorage
        let savedWorkouts = JSON.parse(localStorage.getItem('savedWorkouts')) || [];
        
        // Ta bort workout för vald dag
        savedWorkouts = savedWorkouts.filter(w => w.day.toLowerCase() !== day.toLowerCase());
        
        // Spara uppdaterad lista
        localStorage.setItem('savedWorkouts', JSON.stringify(savedWorkouts));
        
        // Uppdatera UI
        renderSavedWorkouts();
    }
}

// Motivational popups
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

// Add event listeners when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to save workout buttons
    document.querySelectorAll('.btn-primary.btn-lg').forEach(button => {
        button.addEventListener('click', function() {
            // Hitta vilken dag knappen tillhör
            const card = this.closest('.card');
            const day = card.querySelector('.card-title.h4').textContent;
            saveWorkout(day.toLowerCase());
        });
    });
    
    // Render saved workouts
    renderSavedWorkouts();
    
    // Start motivation popups
    scheduleRandomMotivation();
}); 