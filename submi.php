<?php
session_start();
include("config/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HE-ART | Submit Your Artwork</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
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
        .custom-shape-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .custom-shape-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }
        .custom-shape-divider .shape-fill {
            fill: #f3f4f6;
        }

        /* Kenyan-inspired styles */
        .glassmorphism {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
        }
        .category-card:hover {
             transform: translateY(-5px) scale(1.03);
             box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
        .artist-card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        /* Header Styles with Kenyan colors */
        .header-gradient {
            background: linear-gradient(to right, #006600, #cc0000);
        }
        .header-glassmorphism {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            border-radius: 18px;
        }
        
        /* Kenyan pattern background */
        .kenyan-pattern {
            background-color: #222;
            background-image: repeating-linear-gradient(45deg, #006600 0, #006600 10px, transparent 10px, transparent 20px),
                             repeating-linear-gradient(-45deg, #990000 0, #990000 10px, transparent 10px, transparent 20px);
            background-size: 50px 50px;
            background-opacity: 0.1;
        }
        
        /* Buttons with Kenyan color scheme */
        .btn-kenyan-green {
            background-color: #006600;
        }
        .btn-kenyan-green:hover {
            background-color: #008800;
        }
        .btn-kenyan-red {
            background-color: #cc0000;
        }
        .btn-kenyan-red:hover {
            background-color: #ff0000;
        }
        .btn-kenyan-black {
            background-color: #222;
        }
        .btn-kenyan-black:hover {
            background-color: #444;
        }
        
        /* Form inputs with Kenyan inspired styling */
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
        
        /* Progress bar styling */
        .progress-bar {
            background: linear-gradient(to right, #006600, #cc0000);
            height: 6px;
            border-radius: 3px;
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
    </style>
</head>
<body class="bg-gray-900 text-white">
  <!-- Hero -->
 <header class="relative h-96">
        
         <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="imgs/d.jpeg" alt="Artists Background" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>
        <nav class="bg-transparent shadow-lg fixed w-full z-50 glassmorphism">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="playfair text-3xl font-bold text-green-500">E-Art</span>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="index.php" class="border-green-500 text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                            <a href="collections.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Marketplace</a>
                             <a href="gallery.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Gallery</a>
                            <a href="artists.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Artists</a>
                            <a href="about.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">About</a>
                            <a href="contact.php" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Contact</a>
                            
                        </div>
                    </div>
                    
            <div x-show="isOpen" class="sm:hidden bg-gray-900">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="index.php" class="bg-green-800 border-green-500 text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                    <a href="collections.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Marketplace</a>
                    <a href="artists.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Artists</a>
                    <a href="gallery.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Gallery</a>
                    <a href="about.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">About</a>
                    <a href="contact.php" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Contact</a>
                   
                
        </nav>
    
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-6">
        <h2 class="safari-font text-4xl md:text-5xl font-bold mb-2">
            <span class="text-yellow-400">SUBMIT</span> <span class="text-red-400">YOUR ARTWORK</span>
        </h2>
        <p class="text-xl max-w-2xl">Share your Kenyan artistic vision with the world</p>
    </div>
  </header>

  <!-- Multi-step form section -->
  <section class="py-16 md:py-24 relative">
    <div class="absolute inset-0 z-0">
        <img src="imgs/d.jpeg" alt="Kenyan Art Background" class="w-full h-full object-cover opacity-20" />
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black opacity-90"></div>
    </div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Steps indicator -->
        <div class="flex items-center justify-center mb-16">
            <div class="flex flex-col items-center">
                <div class="step-indicator step-active">1</div>
                <span class="text-sm mt-2 text-white">Details</span>
            </div>
            
            <div class="step-line w-20 md:w-32 step-line-active"></div>
            
            <div class="flex flex-col items-center">
                <div class="step-indicator step-upcoming">2</div>
                <span class="text-sm mt-2 text-gray-400">Images</span>
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
        
        <!-- Introduction text -->
        <div class="text-center mb-12">
            <h2 class="playfair text-3xl md:text-4xl font-bold text-white mb-6">Join Our Artist Community</h2>
            <p class="inter text-lg text-gray-300 max-w-3xl mx-auto">
                We're looking for talented Kenyan artists to showcase on our platform. Complete the form below to submit your artwork for consideration by our curatorial team.
            </p>
        </div>
        
        <!-- Form -->
        <div class="glassmorphism p-8 md:p-10 rounded-xl">
        <form id="submit-artwork-form" action="config/process.php" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col space-y-6">
                

                <!-- Step 1: Artwork Details -->
                <div id="step-1" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="artwork-title" class="block text-white text-sm font-medium mb-2 inter">Artwork Title *</label>
                            <input type="text" id="artwork-title" name="artwork-title" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50">
                        </div>
                        
                        <div>
                            <label for="artwork-category" class="block text-white text-sm font-medium mb-2 inter">Category *</label>
                            <select id="artwork-category" name="artwork-category" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50">
                                <option value="">Select Category</option>
                                <option value="maasai">Maasai Art</option>
                                <option value="contemporary">Contemporary</option>
                                <option value="kisii">Kisii Soapstone</option>
                                <option value="kikoi">Kikoi Textiles</option>
                                <option value="painting">Painting</option>
                                <option value="sculpture">Sculpture</option>
                                <option value="mixed-media">Mixed Media</option>
                                <option value="digital">Digital Art</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="artwork-description" class="block text-white text-sm font-medium mb-2 inter">Artwork Description *</label>
                        <textarea id="artwork-description" name="artwork-description" rows="4" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="Describe your artwork, inspiration, techniques used, and its cultural significance..."></textarea>
                    </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="artwork-dimensions" class="block text-white text-sm font-medium mb-2 inter">Dimensions (in cm) *</label>
                            <input type="text" id="artwork-dimensions" name="artwork-dimensions" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="e.g. 60 x 40 x 10">
                        </div>
                        
                        <div>
                            <label for="artwork-medium" class="block text-white text-sm font-medium mb-2 inter">Medium/Materials *</label>
                            <input type="text" id="artwork-medium" name="artwork-medium" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="e.g. Acrylic on canvas, Soapstone, Mixed media">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="artwork-price" class="block text-white text-sm font-medium mb-2 inter">Price (KSh) *</label>
                            <input type="number" id="artwork-price" name="artwork-price" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="e.g. 25000">
                        </div>
                        
                        <div>
                            <label for="artwork-year" class="block text-white text-sm font-medium mb-2 inter">Year Created *</label>
                            <input type="number" id="artwork-year" name="artwork-year" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="e.g. 2025" min="1900" max="2025">
                        </div>
                    </div>
                    
                    <div>
                        <label for="artwork-tags" class="block text-white text-sm font-medium mb-2 inter">Tags (separate with commas)</label>
                        <input type="text" id="artwork-tags" name="artwork-tags" class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="e.g. nature, wildlife, tradition, modern">
                    </div>
                    
                    <div class="pt-6 border-t border-gray-700">
                        <h3 class="text-xl font-bold playfair mb-4">Artist Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="artist-name" class="block text-white text-sm font-medium mb-2 inter">Full Name *</label>
                                <input type="text" id="artist-name" name="artist-name" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50">
                            </div>
                            
                            <div>
                                <label for="artist-email" class="block text-white text-sm font-medium mb-2 inter">Email Address *</label>
                                <input type="email" id="artist-email" name="artist-email" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="artist-phone" class="block text-white text-sm font-medium mb-2 inter">Phone Number *</label>
                                <input type="tel" id="artist-phone" name="artist-phone" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="+254 7XX XXX XXX">
                            </div>
                            
                            <div>
                                <label for="artist-location" class="block text-white text-sm font-medium mb-2 inter">Location *</label>
                                <input type="text" id="artist-location" name="artist-location" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="City, County">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="artist-bio" class="block text-white text-sm font-medium mb-2 inter">Artist Bio *</label>
                            <textarea id="artist-bio" name="artist-bio" rows="4" required class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="Tell us about yourself, your artistic journey, influences, and what drives your creative vision..."></textarea>
                        </div>
                        
                        <div class="mt-6">
                            <label for="artist-website" class="block text-white text-sm font-medium mb-2 inter">Website/Social Media (optional)</label>
                            <input type="url" id="artist-website" name="artist-website" class="input-kenyan w-full py-3 px-4 rounded-lg focus:ring-green-500 bg-gray-800 bg-opacity-50" placeholder="e.g. https://instagram.com/yourusername">
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                    <button type="submit" class="gradient-bg px-8 py-3 rounded-lg text-lg font-semibold neon-shadow">Submit Artwork</button>

                        </button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
  </section>

  <!-- Guidelines and FAQ Section -->
  <<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Submission Guidelines -->
            <div>
                <h2 class="playfair text-3xl font-bold text-white mb-6">Submission Guidelines</h2>
                
                <div class="space-y-6">
                    <!-- Image Requirements -->
                    <div class="glassmorphism p-6 rounded-xl">
                        <div class="flex items-start">
                            <div class="bg-green-700 rounded-full p-2 mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 playfair">Image Requirements</h3>
                                <p class="text-gray-300 inter">Submit 3-5 high-quality images (minimum 2000px on longest side) in JPG or PNG format. Include at least one overall view and detail shots.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Eligible Artwork -->
                    <div class="glassmorphism p-6 rounded-xl">
                        <div class="flex items-start">
                            <div class="bg-red-700 rounded-full p-2 mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 playfair">Eligible Artwork</h3>
                                <p class="text-gray-300 inter">We accept paintings, sculptures, mixed media, photography, digital art, textiles, and traditional Kenyan crafts created within the last three years.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Deadline -->
                    <div class="glassmorphism p-6 rounded-xl">
                        <div class="flex items-start">
                            <div class="bg-yellow-600 rounded-full p-2 mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-10a1 1 0 011 1v2a1 1 0 11-2 0V9a1 1 0 011-1zm0 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2 playfair">Submission Deadline</h3>
                                <p class="text-gray-300 inter">All entries must be submitted by <strong>July 31, 2025</strong>. Late submissions will not be considered.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional Additional Content -->
            <div class="glassmorphism p-6 rounded-xl h-full flex flex-col justify-center text-center">
                <h3 class="text-2xl font-bold text-white mb-4 playfair">Need Help?</h3>
                <p class="text-gray-300 inter mb-4">If you have any questions about the submission process or artwork eligibility, feel free to reach out to our team.</p>
                <a href="contact.php" class="inline-block mt-2 px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<section class="py-16 px-6 md:px-16 bg-gray-800">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="safari-font text-3xl md:text-4xl font-bold mb-6">FOLLOW US ON <span class="text-yellow-400">SOCIAL MEDIA</span></h2>
        <p class="text-gray-300 mb-10">Stay updated with our latest exhibitions, artist spotlights, and events</p>
        
        <div class="flex flex-wrap justify-center gap-6">
            <a href="#" class="bg-gray-900 p-4 rounded-full hover:bg-gray-700 transition-all duration-300">
                <svg class="h-8 w-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </a>
            <a href="#" class="bg-gray-900 p-4 rounded-full hover:bg-gray-700 transition-all duration-300">
                <svg class="h-8 w-8 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
            </a>
           <a href="#" class="bg-gray-900 p-4 rounded-full hover:bg-gray-700 transition-all duration-300">
<svg class="h-8 w-8 text-green-400" fill="currentColor" viewBox="0 0 24 24">
    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.063.925 2.063 2.063 0 1.139-.923 2.065-2.063 2.065zM6.814 20.452H3.861V9h2.953v11.452zM22.225 0H1.771C.792 0 0 .771 0 1.723v20.555C0 23.229.792 24 1.771 24h20.451C23.2 24 24 23.229 24 22.278V1.723C24 .771 23.2 0 22.225 0z"/>
</svg>
</a>
<!-- Facebook -->
<a href="#" class="bg-gray-900 p-4 rounded-full hover:bg-gray-700 transition-all duration-300">
<svg class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
    <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.351C0 23.4.6 24 1.325 24H12.82v-9.294H9.692V11.29h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.464.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.311h3.587l-.467 3.416h-3.12V24h6.116C23.4 24 24 23.4 24 22.675V1.325C24 .6 23.4 0 22.675 0z"/>
</svg>
</a>

<!-- YouTube -->
<a href="#" class="bg-gray-900 p-4 rounded-full hover:bg-gray-700 transition-all duration-300">
<svg class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
    <path d="M23.498 6.186a2.994 2.994 0 00-2.107-2.123C19.765 3.5 12 3.5 12 3.5s-7.765 0-9.391.563A2.994 2.994 0 00.502 6.186 31.398 31.398 0 000 12a31.397 31.397 0 00.502 5.814 2.994 2.994 0 002.107 2.123C4.235 20.5 12 20.5 12 20.5s7.765 0 9.391-.563a2.994 2.994 0 002.107-2.123A31.397 31.397 0 0024 12a31.398 31.398 0 00-.502-5.814zM9.75 15.02V8.98l6.25 3.02-6.25 3.02z"/>
</svg>
</a>
</div>
</div>
</section>
<footer class="bg-gray-900 pt-16 pb-8 px-6 md:px-16 border-t border-gray-800">
<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-16">
        <!-- Company Info -->
        <div>
            <div class="gradient-bg p-2 rounded-lg neon-shadow inline-block mb-4">
                <h3 class="safari-font font-bold text-xl text-white">E-ART </h3>
            </div>
            <p class="text-gray-400 mb-4">Connecting artists with art lovers and collectors. Discover, appreciate, and acquire extraordinary art in our curated marketplace.</p>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 social-icon">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 social-icon">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 social-icon">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 social-icon">
                    <span class="sr-only">Pinterest</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="text-white text-lg font-semibold mb-6">Quick Links</h4>
            <ul class="space-y-3">
                <li><a href="about.html" class="text-gray-400 hover:text-white transition-all duration-300">About Us</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Featured Artists</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Exhibitions</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Art Collections</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Blog & Articles</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Contact Us</a></li>
            </ul>
        </div>

        <!-- Support -->
        <div>
            <h4 class="text-white text-lg font-semibold mb-6">Support</h4>
            <ul class="space-y-3">
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">FAQ</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Shipping & Returns</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Artist Submissions</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Privacy Policy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Terms of Service</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">Cookie Policy</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
       

    <!-- Bottom Section -->
    <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-500 text-sm mb-4 md:mb-0">&copy; 2025 ART SAFARI. All rights reserved.</p>
        <div class="flex space-x-6">
            <a href="#" class="text-gray-500 hover:text-gray-300 text-sm">Privacy</a>
            <a href="#" class="text-gray-500 hover:text-gray-300 text-sm">Terms</a>
            <a href="#" class="text-gray-500 hover:text-gray-300 text-sm">Sitemap</a>
            
        </div>
    </div>
</div>
</footer>
<script>
   
document.addEventListener('DOMContentLoaded', () => {
    const nextBtn = document.getElementById('next-to-step-2');
    const step1 = document.getElementById('step-1');
    
    // This assumes step-2 exists (you'll add it soon)
    const step2 = document.getElementById('step-2');

    nextBtn.addEventListener('click', () => {
        if (step1 && step2) {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
        }
    });
});

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("artwork-form");

    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent default form submission

      const formData = new FormData(form);

      fetch("config/process.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          alert(data.message);
          window.location.href = data.redirect;
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error("Submission failed:", err);
        alert("Something went wrong. Please try again.");
      });
    });
  });



    const step2 = document.getElementById('step-2')
    const step3 = document.getElementById('step-3')
    const step4 = document.getElementById('step-4')
    const prevBtn = document.getElementById('prev-to-step-1')
    const nextBtn2 = document.getElementById('next-to-step-2')
    const nextBtn3 = document.getElementById('next-to-step-4')
    const submitBtn = document.getElementById('submit-btn')
    const backBtn = document.getElementById('back-btn')
    const previewBtn = document.getElementById('preview-btn')
    const uploadBtn = document.getElementById('upload-btn')
    const uploadBtn2 = document.getElementById('upload-btn-2')
    // Add this JavaScript to your form submission page (the page that posts to process.php)

document.addEventListener('DOMContentLoaded', function() {
    // Find the form that submits to process.php
    const form = document.querySelector('form'); // Adjust this selector to target your specific form
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading indicator if you have one
            // document.getElementById('loading-indicator').classList.remove('hidden');
            
            const formData = new FormData(this);
            
            fetch('config/process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                
                // Handle redirect
                if (data.status === 'success' && data.redirect) {
                    // Show success message before redirect
                    alert(data.message);
                    
                    // Construct redirect URL with artwork_id parameter
                    let redirectUrl = data.redirect;
                    if (data.artwork_id) {
                        // Check if the redirect URL already has query parameters
                        redirectUrl += (redirectUrl.includes('?') ? '&' : '?') + 'artwork_id=' + data.artwork_id;
                    }
                    
                    console.log('Redirecting to:', redirectUrl);
                    
                    // Redirect to the specified URL
                    window.location.href = redirectUrl;
                } else {
                    // Show error message
                    alert(data.message || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting form. Please try again.');
            });
        });
    } else {
        console.error('Form not found');
    }
});

    </script>
</body>
</html>