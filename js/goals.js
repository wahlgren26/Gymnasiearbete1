// Get user ID for personalized storage
function getUserId() {
    // Get user ID from PHP session via hidden field
    const userIdField = document.getElementById('current_user_id');
    if (userIdField && userIdField.value) {
        return userIdField.value;
    }
    
    // Fallback to a default ID (should not happen in normal usage)
    return 'default_user';
}

// Data storage models with user-specific keys
const userId = getUserId();
let strengthGoals = JSON.parse(localStorage.getItem(`strengthGoals_${userId}`) || '[]');
let measurementGoals = JSON.parse(localStorage.getItem(`measurementGoals_${userId}`) || '[]');
let targetWeight = localStorage.getItem(`targetWeight_${userId}`) || null;
let goalNotes = JSON.parse(localStorage.getItem(`goalNotes_${userId}`) || '[]');
let completedGoals = JSON.parse(localStorage.getItem(`completedGoals_${userId}`) || '[]');

// Bootstrap components
const strengthGoalModal = new bootstrap.Modal(document.getElementById('strengthGoalModal'));
const editStrengthGoalModal = new bootstrap.Modal(document.getElementById('editStrengthGoalModal'));
const measurementGoalModal = new bootstrap.Modal(document.getElementById('measurementGoalModal'));
const editMeasurementGoalModal = new bootstrap.Modal(document.getElementById('editMeasurementGoalModal'));
const weightGoalModal = new bootstrap.Modal(document.getElementById('weightGoalModal'));
const successToast = new bootstrap.Toast(document.getElementById('successToast'));

// Motivational messages
const motivationalMessages = [
    "Keep Going!",
    "You're Crushing It!",
    "One Step At A Time!",
    "Progress Not Perfection!",
    "You Got This!",
    "Stay Strong!",
    "Believe In Yourself!",
    "Never Give Up!",
    "Make It Happen!",
    "Push Your Limits!"
];

// Helper function to generate unique IDs
function generateId() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2);
}

// Helper function to show success message
function showSuccess(message) {
    document.getElementById('toastMessage').textContent = message;
    successToast.show();
}

// Helper function to update progress bars
function updateProgressBar(progressBar, percentage) {
    progressBar.style.width = `${Math.min(100, Math.max(0, percentage))}%`;
}

// Function to update the goals summary section
function updateGoalsSummary() {
    // Calculate total active goals
    const totalGoals = strengthGoals.length + measurementGoals.length + (targetWeight ? 1 : 0);
    document.getElementById('totalGoalsCount').textContent = totalGoals;
    
    // Show completed goals count
    document.getElementById('completedGoalsCount').textContent = completedGoals.length;
    
    // Calculate streak days (days with notes or achievements)
    const currentDate = new Date();
    const oneDayInMs = 24 * 60 * 60 * 1000;
    let streakDays = 0;
    
    if (goalNotes.length > 0) {
        // Sort notes by date in descending order
        const sortedNotes = [...goalNotes].sort((a, b) => new Date(b.date) - new Date(a.date));
        
        // Find the most recent note
        const latestNoteDate = new Date(sortedNotes[0].date);
        
        // If the most recent note is from today or yesterday, start counting streak
        const daysSinceLatestNote = Math.floor((currentDate - latestNoteDate) / oneDayInMs);
        
        if (daysSinceLatestNote <= 1) {
            streakDays = 1; // Start with 1 for the most recent day
            
            // Check consecutive days
            let checkDate = new Date(latestNoteDate);
            checkDate.setDate(checkDate.getDate() - 1); // Start checking from the day before the latest note
            
            for (let i = 1; i < 30; i++) { // Limit to 30 days max
                const dateString = checkDate.toISOString().split('T')[0];
                const hasNoteOnDate = sortedNotes.some(note => note.date === dateString);
                
                if (hasNoteOnDate) {
                    streakDays++;
                    checkDate.setDate(checkDate.getDate() - 1);
                } else {
                    break;
                }
            }
        }
    }
    
    document.getElementById('goalStreakDays').textContent = streakDays;
    
    // Set random motivational message
    const randomIndex = Math.floor(Math.random() * motivationalMessages.length);
    document.getElementById('motivationalMessage').textContent = motivationalMessages[randomIndex];
}

// Function to render strength goals
function renderStrengthGoals() {
    const container = document.getElementById('strengthGoalsContainer');
    container.innerHTML = '';
    
    if (strengthGoals.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-3">N/A</div>';
        return;
    }
    
    strengthGoals.forEach(goal => {
        const progress = Math.round((goal.current / goal.target) * 100);
        const div = document.createElement('div');
        div.className = 'd-flex justify-content-between mb-2';
        div.innerHTML = `
            <span>${goal.exercise}</span>
            <span class="strength-value" style="cursor: pointer" data-id="${goal.id}">
                ${goal.current}/${goal.target} kg
            </span>
        `;
        container.appendChild(div);
    });
    
    // Calculate average progress for strength progress bar
    if (strengthGoals.length > 0) {
        const avgProgress = strengthGoals.reduce((sum, goal) => 
            sum + (goal.current / goal.target), 0) / strengthGoals.length * 100;
        updateProgressBar(document.querySelector('.card:nth-child(1) .progress-bar'), avgProgress);
    }
    
    // Add click event for editing
    document.querySelectorAll('.strength-value').forEach(value => {
        value.addEventListener('click', function() {
            const goalId = this.getAttribute('data-id');
            const goal = strengthGoals.find(g => g.id === goalId);
            
            if (goal) {
                document.getElementById('editStrengthGoalId').value = goal.id;
                document.getElementById('editStrengthCurrent').value = goal.current;
                document.getElementById('editStrengthTarget').value = goal.target;
                editStrengthGoalModal.show();
            }
        });
    });
}

// Function to render measurement goals
function renderMeasurementGoals() {
    const container = document.getElementById('measurementGoalsContainer');
    container.innerHTML = '';
    
    if (measurementGoals.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-3">N/A</div>';
        return;
    }
    
    measurementGoals.forEach(goal => {
        const progress = Math.round((goal.current / goal.target) * 100);
        const div = document.createElement('div');
        div.className = 'd-flex justify-content-between mb-2';
        div.innerHTML = `
            <span>${goal.name}</span>
            <span class="measurement-value" style="cursor: pointer" data-id="${goal.id}">
                ${goal.current}/${goal.target} cm
            </span>
        `;
        container.appendChild(div);
    });
    
    // Calculate average progress for measurement progress bar
    if (measurementGoals.length > 0) {
        const avgProgress = measurementGoals.reduce((sum, goal) => {
            // For measurements like waist, lower is better
            if (goal.target < goal.current) {
                return sum + ((2 * goal.target - goal.current) / goal.target) * 100;
            } else {
                return sum + (goal.current / goal.target) * 100;
            }
        }, 0) / measurementGoals.length;
        
        updateProgressBar(document.querySelector('.card:nth-child(3) .progress-bar'), avgProgress);
    }
    
    // Add click event for editing
    document.querySelectorAll('.measurement-value').forEach(value => {
        value.addEventListener('click', function() {
            const goalId = this.getAttribute('data-id');
            const goal = measurementGoals.find(g => g.id === goalId);
            
            if (goal) {
                document.getElementById('editMeasurementGoalId').value = goal.id;
                document.getElementById('editMeasurementCurrent').value = goal.current;
                document.getElementById('editMeasurementTarget').value = goal.target;
                editMeasurementGoalModal.show();
            }
        });
    });
}

// Function to update weight display
function updateWeightDisplay() {
    // Get the latest weight from localStorage - use user-specific key
    const weightData = JSON.parse(localStorage.getItem(`weightData_${userId}`) || '[]');
    
    if (weightData.length > 0 && targetWeight) {
        const currentWeight = weightData[weightData.length - 1].weight;
        const remaining = Math.abs(currentWeight - targetWeight);
        
        // Update the display
        document.getElementById('currentWeight').textContent = `${currentWeight} kg`;
        document.getElementById('targetWeight').textContent = `Target: ${targetWeight} kg`;
        document.getElementById('weightRemaining').textContent = `${remaining.toFixed(1)} kg to go!`;
        
        // Update progress bar
        const progressBar = document.querySelector('.card:nth-child(2) .progress-bar');
        const progress = (1 - (remaining / Math.max(10, Math.abs(targetWeight - weightData[0].weight)))) * 100;
        updateProgressBar(progressBar, progress);
    } else {
        // No data or no target
        document.getElementById('currentWeight').textContent = weightData.length > 0 
            ? `${weightData[weightData.length - 1].weight} kg` : 'N/A';
        document.getElementById('targetWeight').textContent = targetWeight 
            ? `Target: ${targetWeight} kg` : 'Target: Not set';
        document.getElementById('weightRemaining').textContent = 'Set target to track progress';
    }
}

// Function to render notes
function renderNotes() {
    const container = document.getElementById('notesTimeline');
    container.innerHTML = '';
    
    if (goalNotes.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-3">No notes yet</div>';
        return;
    }
    
    goalNotes.sort((a, b) => new Date(b.date) - new Date(a.date))
        .forEach(note => {
            const div = document.createElement('div');
            div.className = 'timeline-item mb-3 pb-3 border-bottom';
            div.innerHTML = `
                <div class="d-flex justify-content-between mb-1">
                    <strong>${new Date(note.date).toLocaleDateString()}</strong>
                    <span class="badge ${note.type === 'achievement' ? 'bg-success' : 'bg-primary'}">${note.type === 'achievement' ? 'Achievement' : 'Note'}</span>
                </div>
                <p class="text-muted mb-0">${note.text}</p>
            `;
            container.appendChild(div);
        });
}

// Function to update localStorage with userID as a prefix
function saveToStorage(key, value) {
    localStorage.setItem(`${key}_${userId}`, value);
}

// Function to move a goal to completed goals list
function markGoalAsCompleted(goalType, goal) {
    // Add to completed goals with timestamp
    completedGoals.push({
        id: goal.id,
        type: goalType,
        name: goalType === 'strength' ? goal.exercise : goal.name,
        completedAt: new Date().toISOString()
    });
    
    // Save to localStorage
    saveToStorage('completedGoals', JSON.stringify(completedGoals));
    
    // Show success message
    showSuccess('Goal marked as completed!');
    
    // Update goals summary
    updateGoalsSummary();
}

// Event Listeners for Strength Goals
document.getElementById('addStrengthGoal').addEventListener('click', function() {
    // Reset form
    document.getElementById('strengthGoalForm').reset();
    strengthGoalModal.show();
});

document.getElementById('saveStrengthGoal').addEventListener('click', function() {
    const exercise = document.getElementById('strengthExercise').value;
    const current = parseFloat(document.getElementById('strengthCurrent').value);
    const target = parseFloat(document.getElementById('strengthTarget').value);
    
    if (!exercise || isNaN(current) || isNaN(target)) {
        alert('Please fill in all fields correctly');
        return;
    }
    
    // Add new strength goal
    strengthGoals.push({
        id: generateId(),
        exercise: exercise,
        current: current,
        target: target
    });
    
    // Save to localStorage with user ID
    saveToStorage('strengthGoals', JSON.stringify(strengthGoals));
    
    // Update UI
    renderStrengthGoals();
    strengthGoalModal.hide();
    showSuccess('Strength goal added successfully!');
});

document.getElementById('updateStrengthGoal').addEventListener('click', function() {
    const goalId = document.getElementById('editStrengthGoalId').value;
    const current = parseFloat(document.getElementById('editStrengthCurrent').value);
    const target = parseFloat(document.getElementById('editStrengthTarget').value);
    
    if (isNaN(current) || isNaN(target)) {
        alert('Please fill in all fields correctly');
        return;
    }
    
    // Find and update goal
    const goalIndex = strengthGoals.findIndex(g => g.id === goalId);
    if (goalIndex !== -1) {
        strengthGoals[goalIndex].current = current;
        strengthGoals[goalIndex].target = target;
        
        // Save to localStorage with user ID
        saveToStorage('strengthGoals', JSON.stringify(strengthGoals));
        
        // Update UI
        renderStrengthGoals();
        editStrengthGoalModal.hide();
        showSuccess('Strength goal updated successfully!');
    }
});

document.getElementById('deleteStrengthGoal').addEventListener('click', function() {
    if (confirm('Are you sure you want to delete this goal?')) {
        const goalId = document.getElementById('editStrengthGoalId').value;
        
        // Remove goal
        strengthGoals = strengthGoals.filter(g => g.id !== goalId);
        
        // Save to localStorage with user ID
        saveToStorage('strengthGoals', JSON.stringify(strengthGoals));
        
        // Update UI
        renderStrengthGoals();
        editStrengthGoalModal.hide();
        showSuccess('Strength goal deleted');
    }
});

// Event Listeners for Measurement Goals
document.getElementById('addMeasurementGoal').addEventListener('click', function() {
    // Reset form
    document.getElementById('measurementGoalForm').reset();
    measurementGoalModal.show();
});

document.getElementById('saveMeasurementGoal').addEventListener('click', function() {
    const name = document.getElementById('measurementName').value;
    const current = parseFloat(document.getElementById('measurementCurrent').value);
    const target = parseFloat(document.getElementById('measurementTarget').value);
    
    if (!name || isNaN(current) || isNaN(target)) {
        alert('Please fill in all fields correctly');
        return;
    }
    
    // Add new measurement goal
    measurementGoals.push({
        id: generateId(),
        name: name,
        current: current,
        target: target
    });
    
    // Save to localStorage with user ID
    saveToStorage('measurementGoals', JSON.stringify(measurementGoals));
    
    // Update UI
    renderMeasurementGoals();
    measurementGoalModal.hide();
    showSuccess('Measurement goal added successfully!');
});

document.getElementById('updateMeasurementGoal').addEventListener('click', function() {
    const goalId = document.getElementById('editMeasurementGoalId').value;
    const current = parseFloat(document.getElementById('editMeasurementCurrent').value);
    const target = parseFloat(document.getElementById('editMeasurementTarget').value);
    
    if (isNaN(current) || isNaN(target)) {
        alert('Please fill in all fields correctly');
        return;
    }
    
    // Find and update goal
    const goalIndex = measurementGoals.findIndex(g => g.id === goalId);
    if (goalIndex !== -1) {
        measurementGoals[goalIndex].current = current;
        measurementGoals[goalIndex].target = target;
        
        // Save to localStorage with user ID
        saveToStorage('measurementGoals', JSON.stringify(measurementGoals));
        
        // Update UI
        renderMeasurementGoals();
        editMeasurementGoalModal.hide();
        showSuccess('Measurement updated successfully!');
    }
});

document.getElementById('deleteMeasurementGoal').addEventListener('click', function() {
    if (confirm('Are you sure you want to delete this measurement?')) {
        const goalId = document.getElementById('editMeasurementGoalId').value;
        
        // Remove goal
        measurementGoals = measurementGoals.filter(g => g.id !== goalId);
        
        // Save to localStorage with user ID
        saveToStorage('measurementGoals', JSON.stringify(measurementGoals));
        
        // Update UI
        renderMeasurementGoals();
        editMeasurementGoalModal.hide();
        showSuccess('Measurement deleted');
    }
});

// Event Listeners for Weight Goal
document.getElementById('updateWeightGoal').addEventListener('click', function() {
    // Set current target weight in input
    document.getElementById('targetWeightInput').value = targetWeight || '';
    weightGoalModal.show();
});

document.getElementById('saveWeightGoal').addEventListener('click', function() {
    const newTarget = parseFloat(document.getElementById('targetWeightInput').value);
    
    if (isNaN(newTarget)) {
        alert('Please enter a valid weight');
        return;
    }
    
    // Save to localStorage with user ID
    targetWeight = newTarget;
    saveToStorage('targetWeight', targetWeight);
    
    // Update UI
    updateWeightDisplay();
    weightGoalModal.hide();
    showSuccess('Weight goal updated successfully!');
});

// Handle notes submission
document.getElementById('noteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const date = document.getElementById('noteDate').value;
    const text = document.getElementById('noteText').value;
    const type = document.getElementById('noteType').value;
    
    if (!date || !text) {
        alert('Please fill in all required fields');
        return;
    }
    
    // Add new note
    goalNotes.push({
        id: generateId(),
        date: date,
        text: text,
        type: type
    });
    
    // Save to localStorage with user ID
    saveToStorage('goalNotes', JSON.stringify(goalNotes));
    
    // Reset form
    this.reset();
    document.getElementById('noteDate').valueAsDate = new Date();
    
    // Update UI
    renderNotes();
    showSuccess('Note added successfully!');
});

// Initial setup on document load
document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default for note form
    document.getElementById('noteDate').valueAsDate = new Date();
    
    // Render all components
    renderStrengthGoals();
    renderMeasurementGoals();
    updateWeightDisplay();
    renderNotes();
    updateGoalsSummary();
    
    // Listen for storage events (for cross-tab updates)
    window.addEventListener('storage', function(e) {
        const userId = getUserId();
        if (e.key === `strengthGoals_${userId}`) {
            strengthGoals = JSON.parse(e.newValue || '[]');
            renderStrengthGoals();
            updateGoalsSummary();
        } else if (e.key === `measurementGoals_${userId}`) {
            measurementGoals = JSON.parse(e.newValue || '[]');
            renderMeasurementGoals();
            updateGoalsSummary();
        } else if (e.key === `targetWeight_${userId}`) {
            targetWeight = e.newValue;
            updateWeightDisplay();
            updateGoalsSummary();
        } else if (e.key === `weightData_${userId}`) {
            updateWeightDisplay();
        } else if (e.key === `goalNotes_${userId}`) {
            goalNotes = JSON.parse(e.newValue || '[]');
            renderNotes();
            updateGoalsSummary();
        } else if (e.key === `completedGoals_${userId}`) {
            completedGoals = JSON.parse(e.newValue || '[]');
            updateGoalsSummary();
        }
    });
}); 