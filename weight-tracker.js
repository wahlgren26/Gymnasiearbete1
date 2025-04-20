// Initialize chart
let weightChart;

// Load and display weight data
function loadWeightData() {
    const weightData = JSON.parse(localStorage.getItem('weightData') || '[]');
    const targetWeight = localStorage.getItem('targetWeight') || 70; // Default target

    if (weightData.length > 0) {
        // Update statistics
        const startWeight = weightData[0].weight;
        const currentWeight = weightData[weightData.length - 1].weight;
        const change = currentWeight - startWeight;

        document.getElementById('startWeight').textContent = `${startWeight} kg`;
        document.getElementById('currentWeight').textContent = `${currentWeight} kg`;
        document.getElementById('weightChange').textContent = `${change.toFixed(1)} kg`;

        // Update chart
        const dates = weightData.map(entry => new Date(entry.date).toLocaleDateString());
        const weights = weightData.map(entry => entry.weight);

        if (weightChart) {
            weightChart.destroy();
        }

        const ctx = document.getElementById('weightChart').getContext('2d');
        weightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Weight',
                    data: weights,
                    borderColor: '#0d6efd',
                    tension: 0.4
                }]
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
                <td class="${weightChange > 0 ? 'text-danger' : 'text-success'}">
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
                alert('Please enter both weight and date');
                return;
            }

            const weightData = JSON.parse(localStorage.getItem('weightData') || '[]');
            weightData.push({
                date: new Date(date).toISOString(),
                weight: weight,
                notes: notes
            });

            localStorage.setItem('weightData', JSON.stringify(weightData));
            
            // Reset form
            this.reset();
            document.getElementById('date').valueAsDate = new Date();
            
            // Reload data
            loadWeightData();

            // Show success message
            alert('Weight logged successfully!');
        });
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
        if (e.key === 'weightData') {
            loadWeightData();
        }
    });
});

// Delete entry function
function deleteEntry(date) {
    if (confirm('Are you sure you want to delete this entry?')) {
        let weightData = JSON.parse(localStorage.getItem('weightData') || '[]');
        weightData = weightData.filter(entry => entry.date !== date);
        localStorage.setItem('weightData', JSON.stringify(weightData));
        loadWeightData();
    }
}
