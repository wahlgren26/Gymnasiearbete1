// Initialize chart
let weightChart;

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

// Function to update localStorage with userID as a prefix
function saveToStorage(key, value) {
    const userId = getUserId();
    localStorage.setItem(`${key}_${userId}`, value);
}

// Function to get data from localStorage with userID as a prefix
function getFromStorage(key, defaultValue = null) {
    const userId = getUserId();
    const value = localStorage.getItem(`${key}_${userId}`);
    return value !== null ? value : defaultValue;
}

// Function to show toast notifications
function showToast(message, type = 'success') {
    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="lni lni-${type === 'success' ? 'checkmark-circle' : 'alarm-clock'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.querySelector('.toast-container').appendChild(toastEl);
    
    const toast = new bootstrap.Toast(toastEl, {
        delay: 3000,
        autohide: true
    });
    
    toast.show();
    
    // Remove the element after it's hidden
    toastEl.addEventListener('hidden.bs.toast', function() {
        toastEl.remove();
    });
}

// Update progress bar based on current and target weight
function updateGoalProgress(currentWeight, targetWeight, startWeight) {
    const progressBar = document.getElementById('goalProgress');
    const progressText = document.getElementById('goalProgressText');
    
    if (!progressBar || !progressText || !currentWeight || !targetWeight) return;
    
    // If target weight is higher than start weight (gaining)
    if (targetWeight > startWeight) {
        const totalToGain = targetWeight - startWeight;
        const gainedSoFar = currentWeight - startWeight;
        const percentComplete = Math.min(100, Math.max(0, (gainedSoFar / totalToGain) * 100));
        
        progressBar.style.width = `${percentComplete}%`;
        progressBar.className = 'progress-bar bg-success';
        progressText.textContent = `${percentComplete.toFixed(1)}% of goal weight (${gainedSoFar.toFixed(1)} of ${totalToGain.toFixed(1)} kg to gain)`;
    } 
    // If target weight is lower than start weight (losing)
    else if (targetWeight < startWeight) {
        const totalToLose = startWeight - targetWeight;
        const lostSoFar = startWeight - currentWeight;
        const percentComplete = Math.min(100, Math.max(0, (lostSoFar / totalToLose) * 100));
        
        progressBar.style.width = `${percentComplete}%`;
        progressBar.className = 'progress-bar bg-info';
        progressText.textContent = `${percentComplete.toFixed(1)}% of goal weight (${lostSoFar.toFixed(1)} of ${totalToLose.toFixed(1)} kg to lose)`;
    } 
    // If target weight is the same as start weight (maintaining)
    else {
        const difference = Math.abs(currentWeight - targetWeight);
        
        progressBar.style.width = currentWeight === targetWeight ? '100%' : '50%';
        progressBar.className = 'progress-bar bg-warning';
        progressText.textContent = `Target is to maintain at ${targetWeight} kg (current difference: ${difference.toFixed(1)} kg)`;
    }
}

// Load and display weight data
function loadWeightData() {
    const userId = getUserId();
    const weightData = JSON.parse(getFromStorage('weightData', '[]'));
    const targetWeightString = getFromStorage('targetWeight', null);
    const targetWeight = targetWeightString ? parseFloat(targetWeightString) : null;
    
    // Update target weight display
    const targetWeightDisplay = document.getElementById('targetWeightDisplay');
    if (targetWeightDisplay) {
        targetWeightDisplay.textContent = targetWeight ? `${targetWeight} kg` : 'N/A';
    }
    
    // Load target into form if available
    const targetWeightInput = document.getElementById('targetWeight');
    if (targetWeightInput && !targetWeightInput.value && targetWeight) {
        targetWeightInput.value = targetWeight;
    }

    if (weightData.length > 0) {
        // Update statistics
        const startWeight = weightData[0].weight;
        const currentWeight = weightData[weightData.length - 1].weight;
        const change = currentWeight - startWeight;

        document.getElementById('startWeight').textContent = `${startWeight} kg`;
        document.getElementById('currentWeight').textContent = `${currentWeight} kg`;
        
        // Set change color based on if it's a gain or loss
        const weightChangeEl = document.getElementById('weightChange');
        weightChangeEl.textContent = `${change.toFixed(1)} kg`;
        
        if (change > 0) {
            weightChangeEl.classList.remove('text-success');
            weightChangeEl.classList.add('text-danger');
        } else if (change < 0) {
            weightChangeEl.classList.remove('text-danger');
            weightChangeEl.classList.add('text-success');
        }
        
        // Update goal progress only if target weight is set
        if (targetWeight) {
            updateGoalProgress(currentWeight, targetWeight, startWeight);
        } else {
            // No target set
            const progressBar = document.getElementById('goalProgress');
            const progressText = document.getElementById('goalProgressText');
            if (progressBar && progressText) {
                progressBar.style.width = '0%';
                progressBar.className = 'progress-bar';
                progressText.textContent = 'No target weight set';
            }
        }

        // Update chart
        const dates = weightData.map(entry => new Date(entry.date).toLocaleDateString());
        const weights = weightData.map(entry => entry.weight);

        if (weightChart) {
            weightChart.destroy();
        }

        const ctx = document.getElementById('weightChart').getContext('2d');
        const datasets = [
            {
                label: 'Weight',
                data: weights,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }
        ];
        
        // Only add target line if target weight is set
        if (targetWeight) {
            datasets.push({
                label: 'Target',
                data: Array(dates.length).fill(targetWeight),
                borderColor: '#198754',
                borderWidth: 2,
                borderDash: [5, 5],
                fill: false,
                pointRadius: 0
            });
        }
        
        weightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Update table
        const tableBody = document.getElementById('weightHistory');
        tableBody.innerHTML = '';
        
        weightData.slice().reverse().forEach((entry, index) => {
            const prevWeight = index < weightData.length - 1 ? weightData[weightData.length - 2 - index].weight : entry.weight;
            const weightChange = entry.weight - prevWeight;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${new Date(entry.date).toLocaleDateString()}</td>
                <td>${entry.weight} kg</td>
                <td class="${weightChange > 0 ? 'text-danger' : (weightChange < 0 ? 'text-success' : '')}">
                    ${weightChange !== 0 ? (weightChange > 0 ? '+' : '') + weightChange.toFixed(1) : '0'} kg
                </td>
                <td>${entry.notes || '-'}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteEntry('${entry.date}')">
                        <i class="lni lni-trash-can"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        // No weight data yet
        document.getElementById('startWeight').textContent = '-- kg';
        document.getElementById('currentWeight').textContent = '-- kg';
        document.getElementById('weightChange').textContent = '-- kg';
        document.getElementById('goalProgress').style.width = '0%';
        document.getElementById('goalProgressText').textContent = 'No data yet';
        
        // Clear chart if exists
        if (weightChart) {
            weightChart.destroy();
            weightChart = null;
        }
    }
}

// Fix the form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const weightForm = document.getElementById('weightForm');
    if (weightForm) {
        weightForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const weight = parseFloat(document.getElementById('weight').value);
            const date = document.getElementById('date').value;
            const notes = document.getElementById('notes').value;

            if (!weight || !date) {
                showToast('Please enter both weight and date', 'danger');
                return;
            }

            const userId = getUserId();
            const weightData = JSON.parse(getFromStorage('weightData', '[]'));
            
            // Check if an entry for this date already exists
            const existingEntryIndex = weightData.findIndex(entry => 
                new Date(entry.date).toDateString() === new Date(date).toDateString()
            );
            
            if (existingEntryIndex !== -1) {
                if (confirm('An entry for this date already exists. Do you want to update it?')) {
                    weightData[existingEntryIndex] = {
                        date: new Date(date).toISOString(),
                        weight: weight,
                        notes: notes
                    };
                } else {
                    return;
                }
            } else {
                weightData.push({
                    date: new Date(date).toISOString(),
                    weight: weight,
                    notes: notes
                });
            }

            // Sort the entries by date
            weightData.sort((a, b) => new Date(a.date) - new Date(b.date));

            saveToStorage('weightData', JSON.stringify(weightData));
            
            // Reset form
            this.reset();
            document.getElementById('date').valueAsDate = new Date();
            
            // Reload data
            loadWeightData();

            // Show success message
            showToast('Weight logged successfully!');
        });
    }
    
    // Handle target weight form
    const targetForm = document.getElementById('targetForm');
    if (targetForm) {
        targetForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const targetWeight = parseFloat(document.getElementById('targetWeight').value);
            
            if (!targetWeight) {
                showToast('Please enter a valid target weight', 'danger');
                return;
            }
            
            saveToStorage('targetWeight', targetWeight.toString());
            showToast('Target weight set successfully!');
            loadWeightData();
        });
        
        // Lägg till en knapp för att ta bort målvikten
        const resetTargetBtn = document.createElement('button');
        resetTargetBtn.type = 'button';
        resetTargetBtn.className = 'btn btn-outline-secondary mt-2 w-100';
        resetTargetBtn.textContent = 'Reset Target Weight';
        resetTargetBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove your target weight?')) {
                // Ta bort målvikten från localStorage
                localStorage.removeItem(`targetWeight_${getUserId()}`);
                
                // Återställ formuläret
                document.getElementById('targetWeight').value = '';
                
                // Uppdatera UI
                loadWeightData();
                showToast('Target weight removed');
            }
        });
        
        // Lägg till knappen efter formuläret
        targetForm.parentNode.insertBefore(resetTargetBtn, targetForm.nextSibling);
    }

    // Set today's date as default
    const dateInput = document.getElementById('date');
    if (dateInput) {
        dateInput.valueAsDate = new Date();
    }
    
    // Load initial data
    loadWeightData();
    
    // Listen for changes from other pages
    window.addEventListener('storage', function(e) {
        const userId = getUserId();
        if (e.key === `weightData_${userId}` || e.key === `targetWeight_${userId}`) {
            loadWeightData();
        }
    });
});

// Delete entry function
function deleteEntry(date) {
    if (confirm('Are you sure you want to delete this entry?')) {
        const userId = getUserId();
        let weightData = JSON.parse(getFromStorage('weightData', '[]'));
        weightData = weightData.filter(entry => entry.date !== date);
        saveToStorage('weightData', JSON.stringify(weightData));
        loadWeightData();
        showToast('Entry deleted successfully');
    }
}
