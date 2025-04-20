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
    </style>
</head>

<body>
    <div class="wrapper">
        <!--start of sidebar-->
        <?php include 'sidebar.php'; ?>
        <!--end of sidebar-->

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
                            <?php
                            // This would normally come from a database
                            $sampleImages = [
                                ['date' => '2024-03-15', 'image' => 'path/to/image1.jpg', 'notes' => 'Starting my journey'],
                                ['date' => '2024-03-01', 'image' => 'path/to/image2.jpg', 'notes' => 'One month progress'],
                                // Add more sample entries as needed
                            ];

                            // Template for new uploads will match this structure
                            foreach ($sampleImages as $image) {
                                echo '<div class="col-md-6 col-lg-4">';
                                echo '<div class="card h-100 shadow-sm">';
                                echo '<div class="card-img-top position-relative" style="height: 200px; background: #f8f9fa;">';
                                echo '<img src="' . htmlspecialchars($image['image']) . '" class="w-100 h-100 object-fit-cover" alt="Progress">';
                                // Add delete button overlay
                                echo '<button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-btn" 
                                        onclick="deleteImage(this)">
                                        <i class="lni lni-trash-can"></i>
                                      </button>';
                                echo '</div>';
                                echo '<div class="card-body">';
                                echo '<div class="d-flex justify-content-between align-items-center mb-2">';
                                echo '<h6 class="card-title mb-0">' . date('F j, Y', strtotime($image['date'])) . '</h6>';
                                echo '<span class="badge bg-primary">' . timeAgo($image['date']) . '</span>';
                                echo '</div>';
                                if (!empty($image['notes'])) {
                                    echo '<p class="card-text small text-muted">' . htmlspecialchars($image['notes']) . '</p>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }

                            function timeAgo($date) {
                                $timestamp = strtotime($date);
                                $difference = time() - $timestamp;
                                
                                if ($difference < 60) {
                                    return "Just now";
                                } elseif ($difference < 3600) {
                                    return round($difference/60) . "m ago";
                                } elseif ($difference < 86400) {
                                    return round($difference/3600) . "h ago";
                                } elseif ($difference < 2592000) {
                                    return round($difference/86400) . "d ago";
                                } else {
                                    return date('M j', $timestamp);
                                }
                            }
                            ?>
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
    <script src="script.js"></script>
    <script>
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
            
            const newItem = document.createElement('div');
            newItem.className = 'col-md-6 col-lg-4';
            newItem.innerHTML = `
                <div class="card h-100 shadow-sm">
                    <div class="card-img-top position-relative" style="height: 200px; background: #f8f9fa;">
                        <img src="${imageUrl}" class="w-100 h-100 object-fit-cover" alt="Progress">
                        <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-btn" 
                                onclick="deleteImage(this)">
                            <i class="lni lni-trash-can"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="card-title mb-0">${new Date(date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</h6>
                            <span class="badge bg-primary">Just now</span>
                        </div>
                        ${notes ? `<p class="card-text small text-muted">${notes}</p>` : ''}
                    </div>
                </div>
            `;

            // Add to gallery
            document.getElementById('gallery').insertBefore(newItem, document.getElementById('gallery').firstChild);
            
            // Reset form and preview
            this.reset();
            preview.classList.add('d-none');
            
            // Show success message
            alert('Progress picture uploaded successfully!');
        });

        // Add these functions for delete functionality
        let deletedImage = null;
        let deletedImageHTML = null;
        let undoToast = null;

        document.addEventListener('DOMContentLoaded', function() {
            undoToast = new bootstrap.Toast(document.getElementById('undoToast'), {
                delay: 5000
            });
        });

        function deleteImage(button) {
            // Store the card element and its HTML for potential undo
            deletedImage = button.closest('.col-md-6');
            deletedImageHTML = deletedImage.outerHTML;
            
            // Add fade-out animation
            deletedImage.style.transition = 'all 0.3s ease';
            deletedImage.style.opacity = '0';
            deletedImage.style.transform = 'scale(0.8)';
            
            // Remove element after animation
            setTimeout(() => {
                deletedImage.remove();
                // Show undo toast
                undoToast.show();
            }, 300);
        }

        function undoDelete() {
            if (deletedImageHTML) {
                // Create temporary container
                const temp = document.createElement('div');
                temp.innerHTML = deletedImageHTML;
                const newElement = temp.firstChild;
                
                // Insert at the same position
                document.getElementById('gallery').insertBefore(newElement, document.getElementById('gallery').firstChild);
                
                // Add fade-in animation
                newElement.style.opacity = '0';
                newElement.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    newElement.style.transition = 'all 0.3s ease';
                    newElement.style.opacity = '1';
                    newElement.style.transform = 'scale(1)';
                }, 50);
                
                // Clear deleted image data
                deletedImageHTML = null;
                deletedImage = null;
                
                // Hide toast
                undoToast.hide();
            }
        }
    </script>

    <!-- Add confirmation modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100">Delete Progress Picture?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this progress picture? This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

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
</body>
</html>