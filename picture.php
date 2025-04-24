<?php
// Include session handler at the very beginning
include 'session_handler.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Progress Photos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/picture.css">
    <style>
        .upload-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .upload-area {
            position: relative;
            min-height: 200px;
            border: 2px dashed #0d6efd;
            border-radius: 1rem;
            background: rgba(13, 110, 253, 0.05);
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #0a58ca;
            background: rgba(13, 110, 253, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .upload-content {
            text-align: center;
            pointer-events: none;
        }

        .upload-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .upload-input {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .preview-container {
            margin-top: 2rem;
        }

        .preview-image {
            max-width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .date-input {
            max-width: 200px;
        }

        .progress-gallery {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        .card {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .badge {
            font-weight: 500;
        }

        .delete-btn {
            opacity: 0;
            transition: all 0.2s ease;
            z-index: 2;
        }

        .card:hover .delete-btn {
            opacity: 1;
        }

        .delete-btn:hover {
            background-color: #dc3545;
            transform: scale(1.1);
        }

        /* Add confirmation modal styles */
        .modal-confirm {
            color: #636363;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 1rem;
            border: none;
        }

        .modal-confirm .modal-header {
            border-bottom: none;   
            position: relative;
            text-align: center;
            margin: -20px -20px 0;
            border-radius: 1rem 1rem 0 0;
            padding: 35px;
        }

        .modal-confirm .modal-header {
            background: #dc3545;
            color: #fff;
        }

        .modal-confirm .modal-body {
            padding: 20px;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 0 0 1rem 1rem;
            padding: 10px 15px 20px;
        }

        .toast-container {
            z-index: 9999;
        }

        .undo-toast {
            background: #343a40;
            color: white;
        }

        .undo-btn {
            color: #0d6efd;
            text-decoration: underline;
            cursor: pointer;
        }

        .undo-btn:hover {
            color: #0a58ca;
        }
        
        .no-images {
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            border-radius: 0.5rem;
            color: #6c757d;
        }

        .image-modal-content {
            max-width: 90%;
            max-height: 90vh;
            object-fit: contain;
        }

        .img-card-container {
            cursor: pointer;
            overflow: hidden;
        }

        .img-card-container img {
            transition: transform 0.3s ease;
        }

        .img-card-container:hover img {
            transform: scale(1.05);
        }

        .modal-image-date {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .modal-image-notes {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
            color: #212529;
        }
    </style>
</head>

<body>
    <!-- Hidden input to store the current user ID for JavaScript -->
    <input type="hidden" id="current_user_id" value="<?php echo $_SESSION['user_id']; ?>">
    
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>


        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Progress Pictures</h1>
                    
                    <div class="upload-container">
                        <form id="uploadForm" class="mb-4">
                            <div class="mb-4">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control date-input" required>
                            </div>

                            <div class="upload-area mb-4">
                                <div class="upload-content">
                                    <i class="lni lni-image upload-icon"></i>
                                    <h5 class="mb-2">Drag & drop your progress picture here</h5>
                                    <p class="text-muted mb-0">or click to upload</p>
                                </div>
                                <input type="file" class="upload-input" accept="image/*" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Notes (optional)</label>
                                <textarea class="form-control" rows="3" 
                                    placeholder="Add any notes about your progress..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="lni lni-upload me-2"></i>Save Progress
                            </button>
                        </form>

                        <div id="preview" class="preview-container d-none">
                            <h5 class="mb-3">Preview</h5>
                            <img src="" alt="Preview" class="preview-image">
                        </div>
                    </div>

                    <!-- New Gallery Section -->
                    <div class="progress-gallery">
                        <h2 class="h3 mb-4">Progress Timeline</h2>
                        <div class="row g-4" id="gallery">
                            <!-- Images will be loaded here via JavaScript -->
                        </div>
                        <!-- No images message -->
                        <div id="noImages" class="no-images">
                            <i class="lni lni-gallery fs-1 d-block mb-3"></i>
                            <h5>No progress pictures yet</h5>
                            <p>Upload your first picture to start tracking your progress</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script>
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
        
        // Load progress pictures from localStorage
        function loadProgressPictures() {
            const userId = getUserId();
            const progressPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}`) || '[]');
            const gallery = document.getElementById('gallery');
            const noImages = document.getElementById('noImages');
            
            // Clear existing content
            gallery.innerHTML = '';
            
            // Show "no images" message if there are no pictures
            if (progressPictures.length === 0) {
                noImages.classList.remove('d-none');
                return;
            }
            
            // Hide "no images" message if there are pictures
            noImages.classList.add('d-none');
            
            // Sort by date (newest first)
            progressPictures.sort((a, b) => new Date(b.date) - new Date(a.date));
            
            // Add each picture to the gallery
            progressPictures.forEach((picture, index) => {
                // Använd createdAt istället för date för att beräkna timeAgo
                const timeAgo = picture.createdAt ? getTimeAgo(picture.createdAt) : getTimeAgo(picture.date);
                
                const newItem = document.createElement('div');
                newItem.className = 'col-md-6 col-lg-4';
                newItem.innerHTML = `
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top position-relative img-card-container" style="height: 200px; background: #f8f9fa;" data-index="${index}">
                            <img src="${picture.imageUrl}" class="w-100 h-100 object-fit-cover" alt="Progress">
                            <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-btn" 
                                    data-index="${index}">
                                <i class="lni lni-trash-can"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">${new Date(picture.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</h6>
                                <span class="badge bg-primary">${timeAgo}</span>
                            </div>
                            ${picture.notes ? `<p class="card-text small text-muted">${picture.notes}</p>` : ''}
                        </div>
                    </div>
                `;
                
                gallery.appendChild(newItem);
            });
            
            // Add event listeners to delete buttons and image containers
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Förhindra att klicket triggar förälder-elementet
                    const index = parseInt(this.getAttribute('data-index'));
                    deleteImage(index);
                });
            });

            // Lägg till klick-händelser på bilderna för att visa dem i stort format
            document.querySelectorAll('.img-card-container').forEach(container => {
                container.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    showImageModal(index);
                });
            });
        }
        
        // Function to calculate time ago
        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            
            // Kontrollera om datumet är giltigt
            if (isNaN(date.getTime())) {
                return "Unknown date";
            }
            
            const difference = now - date;
            
            const seconds = Math.floor(difference / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            const months = Math.floor(days / 30);
            
            if (seconds < 60) {
                return "Just now";
            } else if (minutes < 60) {
                return minutes + "m ago";
            } else if (hours < 24) {
                return hours + "h ago";
            } else if (days < 30) {
                return days + "d ago";
            } else {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            }
        }

        // Handle file upload and preview
        const uploadInput = document.querySelector('.upload-input');
        const uploadArea = document.querySelector('.upload-area');
        const preview = document.getElementById('preview');
        const previewImage = preview.querySelector('img');

        uploadInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.style.borderStyle = 'solid';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.style.borderStyle = 'dashed';
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.style.borderStyle = 'dashed';
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                uploadInput.files = e.dataTransfer.files;
                const event = new Event('change');
                uploadInput.dispatchEvent(event);
            }
        });

        // Handle form submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const date = this.querySelector('input[type="date"]').value;
            const notes = this.querySelector('textarea').value;
            const imageUrl = previewImage.src;
            
            if (!date || !imageUrl) {
                alert('Please select a date and image');
                return;
            }
            
            // Get existing pictures
            const userId = getUserId();
            const progressPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}`) || '[]');
            
            // Add new picture
            progressPictures.push({
                date: date,
                notes: notes,
                imageUrl: imageUrl,
                createdAt: new Date().toISOString()
            });
            
            // Save to localStorage
            localStorage.setItem(`progressPictures_${userId}`, JSON.stringify(progressPictures));
            
            // Reset form and preview
            this.reset();
            preview.classList.add('d-none');
            
            // Reload pictures
            loadProgressPictures();
            
            // Show success message
            showSuccessToast('Progress picture uploaded successfully!');
        });

        // Variables for handling deleted images
        let deletedPictureIndex = -1;
        let undoToast = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize toast
            undoToast = new bootstrap.Toast(document.getElementById('undoToast'), {
                delay: 5000
            });
            
            // Initialize image modal
            imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            
            // Set today's date as default
            document.querySelector('input[type="date"]').valueAsDate = new Date();
            
            // Load existing pictures
            loadProgressPictures();
        });

        // Delete image function
        function deleteImage(index) {
            const userId = getUserId();
            const progressPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}`) || '[]');
            
            if (index >= 0 && index < progressPictures.length) {
                // Spara den borttagna bilden
                const deletedPicture = progressPictures[index];
                
                // Spara index för potentiell undo (behövs inte egentligen men behåller för kompatibilitet)
                deletedPictureIndex = index;
                
                // Spara borttagen bild i en separat lista
                const deletedPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}_deleted`) || '[]');
                deletedPictures.push(deletedPicture);
                localStorage.setItem(`progressPictures_${userId}_deleted`, JSON.stringify(deletedPictures));
                
                // Ta bort bilden från huvudlistan
                progressPictures.splice(index, 1);
                
                // Spara uppdaterad lista
                localStorage.setItem(`progressPictures_${userId}`, JSON.stringify(progressPictures));
                
                // Ladda om bilder
                loadProgressPictures();
                
                // Visa undo toast
                const undoToastEl = document.getElementById('undoToast');
                if (undoToastEl) {
                    undoToast.show();
                }
            }
        }

        // Undo delete function
        function undoDelete() {
            const userId = getUserId();
            const deletedPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}_deleted`) || '[]');
            
            if (deletedPictures.length > 0) {
                // Hämta den senast borttagna bilden
                const deletedPicture = deletedPictures.pop();
                
                // Lägg tillbaka den i huvudlistan
                const currentPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}`) || '[]');
                currentPictures.push(deletedPicture);
                
                // Spara båda listorna
                localStorage.setItem(`progressPictures_${userId}`, JSON.stringify(currentPictures));
                localStorage.setItem(`progressPictures_${userId}_deleted`, JSON.stringify(deletedPictures));
                
                // Återställ raderat index
                deletedPictureIndex = -1;
                
                // Ladda om bilder
                loadProgressPictures();
                
                // Dölj toast
                undoToast.hide();
            }
        }
        
        // Function to show a success toast
        function showSuccessToast(message) {
            const toastEl = document.createElement('div');
            toastEl.className = 'toast align-items-center text-white bg-success border-0';
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');
            
            toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="lni lni-checkmark-circle me-2"></i>
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

        // Lägg till funktionen för att visa bildmodalen
        function showImageModal(index) {
            const userId = getUserId();
            const progressPictures = JSON.parse(localStorage.getItem(`progressPictures_${userId}`) || '[]');
            
            if (index >= 0 && index < progressPictures.length) {
                const picture = progressPictures[index];
                
                // Sätt bild och information i modalen
                document.getElementById('modalImage').src = picture.imageUrl;
                
                // Formatera datum
                const formattedDate = new Date(picture.date).toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                document.getElementById('modalImageDate').textContent = formattedDate;
                
                // Visa eller dölj anteckningar
                const notesElement = document.getElementById('modalImageNotes');
                if (picture.notes && picture.notes.trim() !== '') {
                    notesElement.textContent = picture.notes;
                    notesElement.classList.remove('d-none');
                } else {
                    notesElement.classList.add('d-none');
                }
                
                // Visa modalen
                imageModal.show();
            }
        }
    </script>

    <!-- Add toast container for undo -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="undoToast" class="toast undo-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex justify-content-between align-items-center">
                <span>Picture deleted</span>
                <div>
                    <button class="btn btn-link text-white p-0 me-2 undo-btn" onclick="undoDelete()">Undo</button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center position-relative p-0">
                    <img id="modalImage" src="" alt="Progress Picture" class="image-modal-content">
                    <div id="modalImageDate" class="modal-image-date"></div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <div id="modalImageNotes" class="modal-image-notes d-none"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>