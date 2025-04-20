<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Redigera Profil</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/editprofile.css">
</head>

<body>
<div class="wrapper">
    <?php include 'sidebar.php'; ?>
    
    <div class="main p-3">
        <div class="profile-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Redigera Profil</h1>
                <a href="profile.php" class="btn btn-outline-secondary"><i class="lni lni-arrow-left"></i> Tillbaka till profil</a>
            </div>
            
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <!-- Profilbild och grundläggande info -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Profilbild & grundinformation</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="profile-pic-wrapper">
                                        <img src="MSNexample.png" alt="Profilbild" class="profile-pic mb-3">
                                        <div class="upload-btn-wrapper">
                                            <button class="btn btn-primary btn-sm"><i class="lni lni-camera"></i> Byt bild</button>
                                            <input type="file" name="profile_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Förnamn</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" value="Anders">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Efternamn</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" value="Andersson">
                                    </div>
                                    <div class="mb-3">
                                        <label for="member_since" class="form-label">Medlem sedan</label>
                                        <input type="month" class="form-control" id="member_since" name="member_since" value="2024-01" readonly>
                                        <small class="text-muted">Medlemsdatum kan inte ändras</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Beskrivning -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Om dig</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="description" class="form-label">Beskrivning</label>
                                <textarea class="form-control" id="description" name="description" rows="4">Tränat aktivt i 3 år med fokus på styrketräning. Gillar att pusha mig själv till nya nivåer och hjälpa andra nå sina träningsmål. Specialiserad inom powerlifting och funktionell träning.</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Personlig information -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Personlig Information</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="age" class="form-label">Ålder</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="age" name="age" value="28">
                                        <span class="input-group-text">år</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="height" class="form-label">Längd</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="height" name="height" value="180">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Vikt</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="weight" name="weight" step="0.1" value="75">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="goal" class="form-label">Träningsmål</label>
                                    <input type="text" class="form-control" id="goal" name="goal" value="Styrkeökning och muskeltillväxt">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Personbästa -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Personbästa</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" id="personal-bests">
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <label for="bench_press" class="form-label">Bänkpress</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="bench_press" name="bench_press" value="100">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Ta bort"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <label for="deadlift" class="form-label">Marklyft</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="deadlift" name="deadlift" value="160">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Ta bort"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <label for="squat" class="form-label">Knäböj</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="squat" name="squat" value="120">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Ta bort"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addExercise">
                                <i class="lni lni-plus"></i> Lägg till övning
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Träningsstatistik -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Träningsstatistik</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="monthly_sessions" class="form-label">Pass denna månad</label>
                                    <input type="number" class="form-control" id="monthly_sessions" name="monthly_sessions" value="12">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="training_hours" class="form-label">Träningstimmar</label>
                                    <input type="number" class="form-control" id="training_hours" name="training_hours" value="18">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="active_programs" class="form-label">Aktiva program</label>
                                    <input type="number" class="form-control" id="active_programs" name="active_programs" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Knappar -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="profile.php" class="btn btn-outline-secondary">Avbryt</a>
                    <button type="submit" class="btn btn-primary">Spara ändringar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script>
    // Visa förhandsvisning av uppladdad bild
    document.querySelector('input[name="profile_image"]').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const src = URL.createObjectURL(e.target.files[0]);
            document.querySelector('.profile-pic').src = src;
        }
    });
    
    // Funktionalitet för att lägga till fler övningar
    document.getElementById('addExercise').addEventListener('click', function() {
        const container = document.getElementById('personal-bests');
        
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-3';
        
        const exerciseItem = document.createElement('div');
        exerciseItem.className = 'exercise-item';
        
        const label = document.createElement('label');
        label.className = 'form-label';
        label.textContent = 'Ny övning';
        
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group';
        
        const input = document.createElement('input');
        input.type = 'number';
        input.className = 'form-control';
        input.name = 'custom_exercise[]';
        input.placeholder = 'Vikt';
        
        const inputGroupText = document.createElement('span');
        inputGroupText.className = 'input-group-text';
        inputGroupText.textContent = 'kg';
        
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-outline-danger remove-exercise';
        removeButton.title = 'Ta bort';
        removeButton.innerHTML = '<i class="lni lni-close"></i>';
        
        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.className = 'form-control mt-2';
        nameInput.name = 'custom_exercise_name[]';
        nameInput.placeholder = 'Övningsnamn';
        
        inputGroup.appendChild(input);
        inputGroup.appendChild(inputGroupText);
        inputGroup.appendChild(removeButton);
        
        exerciseItem.appendChild(label);
        exerciseItem.appendChild(inputGroup);
        exerciseItem.appendChild(nameInput);
        
        col.appendChild(exerciseItem);
        container.appendChild(col);
    });
    
    // Funktionalitet för att ta bort övningar
    document.addEventListener('click', function(event) {
        if (event.target.closest('.remove-exercise')) {
            const button = event.target.closest('.remove-exercise');
            const exerciseItem = button.closest('.col-md-4');
            
            if (confirm('Är du säker på att du vill ta bort denna övning?')) {
                exerciseItem.remove();
            }
        }
    });
</script>
</body>
</html> 