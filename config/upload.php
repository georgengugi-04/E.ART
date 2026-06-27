<?php
include 'connect.php'; // Database connection

$uploadDir = "uploads/";
$maxFileSize = 10 * 1024 * 1024; // 10MB
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

$uploadSuccess = false;
$errorMessage = "";
$success = [];
$errors = [];

// Ensure upload folder exists
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function isValidFile($fileName, $fileSize, $allowedTypes, $maxFileSize) {
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes)) {
        return "Only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
    }
    if ($fileSize > $maxFileSize) {
        return "File '$fileName' is too large.";
    }
    return true;
}

// Upload a single artwork image
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["artwork"])) {
    $file = $_FILES["artwork"];
    $valid = isValidFile($file["name"], $file["size"], $allowedTypes, $maxFileSize);
    if ($valid === true) {
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newFileName = uniqid("art_") . "." . $ext;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            $uploadSuccess = true;
            $success[] = "File uploaded: $newFileName";
        } else {
            $errorMessage = "There was an error uploading your file.";
        }
    } else {
        $errorMessage = $valid;
    }
}

// Upload multiple artwork images
$artwork_id = isset($_GET['artwork_id']) ? intval($_GET['artwork_id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["artwork-images"])) {
    $files = $_FILES["artwork-images"];
    for ($i = 0; $i < count($files["name"]); $i++) {
        if ($files["error"][$i] === UPLOAD_ERR_OK) {
            $valid = isValidFile($files["name"][$i], $files["size"][$i], $allowedTypes, $maxFileSize);
            if ($valid === true) {
                $ext = pathinfo($files["name"][$i], PATHINFO_EXTENSION);
                $newFileName = uniqid("artmulti_") . "." . $ext;
                $targetPath = $uploadDir . $newFileName;

                if (move_uploaded_file($files["tmp_name"][$i], $targetPath)) {
                    $sql = "INSERT INTO artwork_images (artwork_id, image_path) VALUES (?, ?)";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("is", $artwork_id, $targetPath);
                        if ($stmt->execute()) {
                            $success[] = $files["name"][$i] . " uploaded successfully!";
                        } else {
                            $errors[] = "Database error for " . $files["name"][$i];
                        }
                        $stmt->close();
                    }
                } else {
                    $errors[] = "Failed to move file: " . $files["name"][$i];
                }
            } else {
                $errors[] = $valid;
            }
        } else {
            $errors[] = "Upload error for file: " . $files["name"][$i];
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HE-ART | Upload Artwork Images</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Same styles as in your original page -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* All your CSS styles from the original file would go here */
        .safari-font {
            font-family: 'Orbitron', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(90deg, #f59e0b, #ef4444);
        }
        
        .neon-shadow {
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.7);
        }
        
        .artwork-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.8);
        }
        .playfair {
            font-family: 'Playfair Display', serif;
        }
        .inter {
          font-family: 'Inter', sans-serif;
        }
        /* Kenyan flag-inspired colors */
        .bg-gradient-kenyan {
            background: linear-gradient(90deg, #f59e0b, #ef4444);
        }
        .text-gradient-kenyan {
            background: linear-gradient(to right, #006600, #cc0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 20px -5px rgba(0, 102, 0, 0.3), 0 8px 10px -5px rgba(153, 0, 0, 0.2);
        }
        .hero-pattern {
            /* Kenyan-inspired background pattern */
            background-color: #111;
            background-image: 
                radial-gradient(circle at 20% 35%, rgba(0, 102, 0, 0.15) 0%, transparent 35%),
                radial-gradient(circle at 75% 44%, rgba(153, 0, 0, 0.15) 0%, transparent 35%),
                radial-gradient(circle at 50% 80%, rgba(0, 0, 0, 0.1) 0%, transparent 30%);
        }
        .glassmorphism {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
        }
        .input-kenyan {
            background-color: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        .input-kenyan:focus {
            outline: none;
            border-color: #006600;
            box-shadow: 0 0 0 2px rgba(0, 102, 0, 0.2);
        }
        
        /* File upload styling */
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            cursor: pointer;
        }
        .file-upload input[type=file] {
            position: absolute;
            font-size: 100px;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
        
        /* Step indicator */
        .step-indicator {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .step-active {
            background: linear-gradient(to right, #006600, #cc0000);
            color: white;
        }
        .step-completed {
            background: #006600;
            color: white;
        }
        .step-upcoming {
            background: rgba(255, 255, 255, 0.1);
            color: #888;
        }
        .step-line {
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
        }
        .step-line-active {
            background: linear-gradient(to right, #006600, #cc0000);
        }
        
        /* Progress bar */
        .progress-container {
            width: 100%;
            background-color: #1f2937;
            border-radius: 8px;
            overflow: hidden;
            height: 6px;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #006600, #cc0000);
            transition: width 0.3s ease;
        }
        
        /* Upload preview */
        .image-preview {
            width: 150px;
            height: 150px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background-color: #111827;
        }
        
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .remove-image {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .remove-image:hover {
            background-color: #ef4444;
        }
        
        /* Custom success message styling */
        .success-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            width: 90%;
            max-width: 500px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
        }
        
        .success-popup.active {
            opacity: 1;
            visibility: visible;
        }
        
        .success-popup-content {
            background: linear-gradient(135deg, rgba(0, 102, 0, 0.95), rgba(0, 0, 0, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 102, 0, 0.3);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .success-icon {
            margin: 0 auto 20px;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #00cc00, #006600);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(0, 204, 0, 0.4);
        }
        
        .success-actions {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .btn-success {
            background: linear-gradient(to right, #006600, #00cc00);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 102, 0, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 102, 0, 0.4);
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
  <!-- Header similar to your original page -->
  <header class="relative h-64">
    <div class="absolute inset-0 z-0 overflow-hidden">
      <img src="../imgs/d.jpeg" alt="background" class="w-full h-full object-cover opacity-70">
    </div>
    <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>
    <!-- Navigation bar would go here -->
    
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-6">
        <h2 class="safari-font text-4xl md:text-5xl font-bold mb-2">
            <span class="text-yellow-400">UPLOAD</span> <span class="text-red-400">YOUR IMAGES</span>
        </h2>
        <p class="text-xl max-w-2xl">Share the visual beauty of your artwork</p>
    </div>
  </header>

  <!-- Success message overlay (hidden by default) -->
  <div id="successOverlay" class="overlay">
    <div id="successPopup" class="success-popup">
        <div class="success-popup-content">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold safari-font mb-2">UPLOAD SUCCESSFUL!</h3>
            <p class="text-gray-200 mb-4">Your artwork has been uploaded successfully.</p>
            <div class="success-actions">
                <button id="viewPreviewBtn" class="btn-success safari-font">VIEW PREVIEW</button>
            </div>
        </div>
    </div>
  </div>

  <!-- Step 2: Upload Images Section -->
  <section class="py-16 md:py-24 relative">
    <div class="absolute inset-0 z-0">
        <img src="d.jpeg" alt="Kenyan Art Background" class="w-full h-full object-cover opacity-20" />
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black opacity-90"></div>
    </div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Steps indicator -->
        <div class="flex items-center justify-center mb-16">
            <div class="flex flex-col items-center">
                <div class="step-indicator step-completed">1</div>
                <span class="text-sm mt-2 text-white">Details</span>
            </div>
            
            <div class="step-line w-20 md:w-32 step-line-active"></div>
            
            <div class="flex flex-col items-center">
                <div class="step-indicator step-active">2</div>
                <span class="text-sm mt-2 text-white">Images</span>
            </div>
            
            <div class="step-line w-20 md:w-32"></div>
            
            <div class="flex flex-col items-center">
                <div class="step-indicator step-upcoming">3</div>
                <span class="text-sm mt-2 text-gray-400">Preview</span>
            </div>
            
            <div class="step-line w-20 md:w-32"></div>
            
            <div class="flex flex-col items-center">
                <div class="step-indicator step-upcoming">4</div>
                <span class="text-sm mt-2 text-gray-400">Submit</span>
            </div>
        </div>
        
        <!-- Upload instructions -->
        <div class="text-center mb-12">
            <h2 class="playfair text-3xl md:text-4xl font-bold text-white mb-6">Upload Your Artwork Images</h2>
            <p class="inter text-lg text-gray-300 max-w-3xl mx-auto">
                Upload high-quality images that showcase your artwork from different angles. We recommend 3-5 images with at least one overall shot and detail views.
            </p>
        </div>

        <!-- Custom styled success message (replaces the original PHP if block) -->
        <?php if ($uploadSuccess): ?>
        <div id="successMessage" class="glassmorphism p-6 rounded-xl mb-8 border-l-4 border-green-500">
            <div class="flex items-start">
                <div class="bg-green-500 rounded-full p-2 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="safari-font text-xl font-bold text-white mb-1">UPLOAD SUCCESSFUL!</h3>
                    <p class="text-gray-300">Your artwork has been uploaded successfully. You can now continue to preview.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
        <div id="errorMessage" class="glassmorphism p-6 rounded-xl mb-8 border-l-4 border-red-500">
            <div class="flex items-start">
                <div class="bg-red-500 rounded-full p-2 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <h3 class="safari-font text-xl font-bold text-white mb-1">UPLOAD FAILED</h3>
                    <p class="text-gray-300"><?php echo $errorMessage; ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Upload form -->
        <div class="glassmorphism p-8 md:p-10 rounded-xl">
            <form id="image-upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-8">
                    <div class="text-center">
                        <div class="file-upload bg-gray-800 hover:bg-gray-700 transition-colors border border-gray-700 rounded-xl p-8 cursor-pointer mb-6" id="upload-area">
                            <input type="file" name="artwork-images[]" id="artwork-images" accept="image/jpeg, image/jpg, image/png" multiple class="hidden" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-lg font-semibold mb-2">Drag and drop your images here</p>
                            <p class="text-sm text-gray-400 mb-4">or click to browse files</p>
                            <p class="text-xs text-gray-500">JPG or PNG files, max 10MB each (3-5 images recommended)</p>
                        </div>

                        <!-- Upload progress -->
                        <div id="upload-progress" class="hidden">
                            <div class="mb-2 flex justify-between text-sm">
                                <span>Uploading...</span>
                                <span id="progress-percentage">0%</span>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview area (before upload) -->
                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8"></div>

                    <!-- Error messages -->
                    <div id="upload-errors" class="mt-4 text-red-500 text-sm hidden"></div>
                </div>

                <!-- Navigation buttons -->
                <div class="flex justify-between mt-8">
                    <a href="submi.php" class="bg-gray-700 px-6 py-3 rounded-lg text-lg font-semibold hover:bg-gray-600 transition-colors safari-font flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        BACK TO DETAILS
                    </a>

                    <button type="submit" id="continue-button" class="gradient-bg px-8 py-3 rounded-lg text-lg font-semibold neon-shadow hover:opacity-80 transition-opacity safari-font flex items-center" disabled>
                        CONTINUE TO PREVIEW
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tips section -->
        <div class="glassmorphism p-8 rounded-xl mt-8">
            <h3 class="playfair text-2xl font-bold mb-4">Photography Tips</h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-1 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Use natural lighting for the most accurate color representation</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-1 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Capture close-up shots to highlight textures and details</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-1 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Ensure background is neutral and doesn't distract from the art</span>
                </li>
            </ul>
        </div>
    </div>
  </section>
    
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('artwork-images');
    const uploadForm = document.getElementById('image-upload-form');
    const uploadProgress = document.getElementById('upload-progress');
    const progressBar = document.getElementById('progressBar');
    const previewContainer = document.getElementById('preview-container');
    const continueButton = document.getElementById('continue-button');
    const uploadArea = document.getElementById('upload-area');
    
    // Success message elements
    const successOverlay = document.getElementById('successOverlay');
    const successPopup = document.getElementById('successPopup');
    const viewPreviewBtn = document.getElementById('viewPreviewBtn');
    
    // Initialize DataTransfer object for managing selected files
    let dt = new DataTransfer();

    // If upload is successful, show success overlay
    <?php if ($uploadSuccess): ?>
    setTimeout(function() {
        successOverlay.classList.add('active');
        successPopup.classList.add('active');
    }, 500);
    <?php endif; ?>
    
    // View preview button redirects to preview page
    if (viewPreviewBtn) {
        viewPreviewBtn.addEventListener('click', function() {
            window.location.href = '../submi.php';
        });
    }

    // File selection handler with preview functionality
    fileInput.addEventListener('change', handleFileSelect);

    // Click on upload area to trigger file input
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('border-green-500');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('border-green-500');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('border-green-500');
        
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect({target: {files: files}});
        }
    });

    // Handle form submission with Ajax
    uploadForm.addEventListener('submit', function(e) {
        if (fileInput.files.length > 0) {
            e.preventDefault();

            // Show progress bar
            uploadProgress.classList.remove('hidden');
            
            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();
            
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percentComplete + '%';
                    document.getElementById('progress-percentage').textContent = percentComplete + '%';
                }
            });
            
            xhr.addEventListener('load', function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Show success message as a popup
                    setTimeout(function() {
                        successOverlay.classList.add('active');
                        successPopup.classList.add('active');
                        
                        // Hide progress bar
                        uploadProgress.classList.add('hidden');
                    }, 500);
                } else {
                    document.getElementById('upload-errors').classList.remove('hidden');
                    document.getElementById('upload-errors').textContent = 'Upload failed. Please try again.';
                    uploadProgress.classList.add('hidden');
                }
            });

            xhr.addEventListener('error', function() {
                document.getElementById('upload-errors').classList.remove('hidden');
                document.getElementById('upload-errors').textContent = 'Upload failed. Please try again.';
                uploadProgress.classList.add('hidden');
            });

            xhr.open('POST', '.process.php', true);
            xhr.send(formData);
        }
    });

    // Function to handle file selection
    function handleFileSelect(e) {
        const files = Array.from(e.target.files);

        // Check if total number of files is more than 5
        if ((dt.items.length + files.length) > 5) {
            alert('You can only upload up to 5 images.');
            return;
        }

        // Clear previous errors
        const uploadErrors = document.getElementById('upload-errors');
        uploadErrors.classList.add('hidden');
        uploadErrors.textContent = '';

        // Process each selected file
        files.forEach((file) => {
            // Validate file type
            if (!['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'].includes(file.type)) {
                uploadErrors.classList.remove('hidden');
                uploadErrors.textContent = 'Invalid file type. Please upload JPG, JPEG, PNG, GIF, or WEBP files.';
                return;
            }

            // Validate file size (limit to 10MB)
            if (file.size > 10000000) {
                uploadErrors.classList.remove('hidden');
                uploadErrors.textContent = 'File size exceeds 10MB. Please upload smaller files.';
                return;
            }

            // Add valid file to DataTransfer object
            dt.items.add(file);

            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.classList.add('image-preview', 'relative');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded-lg', 'shadow-lg', 'w-full', 'h-auto');

                // Remove image button
                const removeBtn = document.createElement('div');
                removeBtn.classList.add('remove-image', 'absolute', 'top-2', 'right-2', 'cursor-pointer', 'text-white', 'bg-red-600', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center');
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', function () {
                    const index = Array.from(previewContainer.children).indexOf(previewItem);
                    dt.items.remove(index);
                    fileInput.files = dt.files;
                    previewItem.remove();
                    continueButton.disabled = dt.files.length === 0;
                });

                previewItem.appendChild(img);
                previewItem.appendChild(removeBtn);
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });

        // Update file input and disable continue button if no files are selected
        fileInput.files = dt.files;
        continueButton.disabled = dt.files.length === 0;
    }
});

    </script>