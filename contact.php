<?php
session_start();
include("config/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | HE-ART - Discover & Collect Art</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        
        .safari-font {
            font-family: 'Orbitron', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(90deg, #f59e0b, #ef4444);
        }
        
        .neon-shadow {
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.7);
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
        
        /* Glassmorphism effect */
        .glassmorphism {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
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
        
        /* Contact form focus effects */
        .input-focus:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
            outline: none;
        }
        
        /* Map container */
        .map-container {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3);
        }
        
        .contact-card {
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Animation for form submission success */
        @keyframes success-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .success-animation {
            animation: success-pulse 0.5s ease-in-out;
        }

        /* Alert styling */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #10b981;
        }
        
        .alert-error {
            background-color: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- Header/Nav -->
     <nav class="bg-transparent shadow-lg fixed w-full z-50 glassmorphism">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="playfair text-3xl font-bold text-green-500">E-ArtGalla</span>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="index.php" class="border-green-500 text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                            <a href="collections.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Marketplace</a>
                            <a href="artists.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Artists</a>
                            <a href="about.html" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">About</a>
                            <a href="contact.php" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Contact</a>
                            <a href="submi.php" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Submit Art</a>
                           
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="cart.php" class="border-green-500 text-white border-b-2 px-1 pt-1 text-sm font-medium">
                            Cart (<span id="cart-count">0</span>)
                        </a>
                    </div>     
                    
            <div x-show="isOpen" class="sm:hidden bg-gray-900">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="index.php" class="bg-green-800 border-green-500 text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                    <a href="collections.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Marketplace</a>
                    <a href="artists.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Artists</a>
                    <a href="about.html" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">About</a>
                    <a href="contact.php" class="border-transparent text-gray-300 hover:bg-gray-800 hover:border-green-500 hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Contact</a>
                    <a href="submi.php" class="border-transparent text-gray-300 hover:border-green-500 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Submit Art</a>
                </div>
               
        </nav>

    <!-- Hero Section -->
    <header class="relative pt-24 pb-16 md:pt-32 md:pb-24">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="imgs/d.jpeg" alt="Contact Background" class="w-full h-full object-cover opacity-50">
        </div>
        <div class="absolute inset-0 bg-black bg-opacity-70 z-10"></div>
        
        <div class="relative z-20 flex flex-col items-center justify-center text-center px-6">
            <h2 class="safari-font text-4xl md:text-6xl lg:text-7xl font-bold mb-4">
                <span class="text-yellow-400">CONNECT</span> WITH <span class="text-red-400">US</span>
            </h2>
            <p class="text-xl md:text-2xl max-w-2xl mb-8">We'd love to hear from you. Reach out for inquiries, collaborations, or simply to say hello.</p>
            <div class="w-24 h-1 gradient-bg mx-auto mt-2"></div>
        </div>
    </header>

    <!-- Contact Information Cards -->
    <section class="py-16 px-6 md:px-16 bg-gray-900">
    <?php
                    // Display success or error messages if they exist
                    if (isset($_SESSION['message'])) {
                        $message_type = $_SESSION['message_type'] ?? 'success';
                        echo '<div class="alert alert-' . $message_type . '">' . $_SESSION['message'] . '</div>';
                        // Clear the message after displaying it
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                    }
                    ?>
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Contact Card 1 -->
                <div class="contact-card bg-gray-800 rounded-xl p-8 text-center transition-all duration-300">
                    <div class="w-16 h-16 mx-auto bg-yellow-500 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="safari-font text-xl font-bold mb-4">PHONE</h3>
                    <p class="text-gray-300">We're available to answer your calls Monday through Friday, 9:00 AM to 5:00 PM EAT.</p>
                    <p class="text-yellow-400 mt-4 font-medium">+254-7 00110527</p>
                </div>
                
                <!-- Contact Card 2 -->
                <div class="contact-card bg-gray-800 rounded-xl p-8 text-center transition-all duration-300">
                    <div class="w-16 h-16 mx-auto bg-red-500 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="safari-font text-xl font-bold mb-4">EMAIL</h3>
                    <p class="text-gray-300">Send us an email and we'll get back to you within 24 hours during business days.</p>
                    <p class="text-red-400 mt-4 font-medium">eart@gmail.com</p>
                </div>
                
                <!-- Contact Card 3 -->
                <div class="contact-card bg-gray-800 rounded-xl p-8 text-center transition-all duration-300">
                    <div class="w-16 h-16 mx-auto bg-green-500 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="safari-font text-xl font-bold mb-4">LOCATION</h3>
                    <p class="text-gray-300">Visit our gallery in person to explore our collections and meet our team.</p>
                    <p class="text-green-400 mt-4 font-medium">The Junction Mall,  Nairobi, Kenya</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 px-6 md:px-16 bg-gray-800">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Form Column -->
                <div>
                    <h2 class="safari-font text-3xl md:text-4xl font-bold mb-6">SEND US A <span class="text-yellow-400">MESSAGE</span></h2>
                    <p class="text-gray-300 mb-8">Have questions or want to discuss art acquisitions? Fill out the form below and we'll be in touch shortly.</p>
                   
                    
                    <form id="contact-form" class="space-y-6" action="configs/message.php" method="post">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" >
                            <div>
                                <label for="name" class="block text-sm font-medium safari-font mb-2">FULL NAME</label>
                                <input type="text" id="name" name="name" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white input-focus" required>
                                <p id="name-error" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium safari-font mb-2">EMAIL</label>
                                <input type="email" id="email" name="email" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white input-focus" required>
                                <p id="email-error" class="text-red-500 text-xs mt-1"></p>
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium safari-font mb-2">PHONE (OPTIONAL)</label>
                            <input type="tel" id="phone" name="phone" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white input-focus">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium safari-font mb-2">SUBJECT</label>
                            <select id="subject" name="subject" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white input-focus" required>
                                <option value="general">General Inquiry</option>
                                <option value="purchase">Art Purchase</option>
                                <option value="artist">Artist Submission</option>
                                <option value="event">Event Information</option>
                                <option value="feedback">Feedback</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium safari-font mb-2">MESSAGE</label>
                            <textarea id="message" name="message" rows="5" class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white input-focus" required></textarea>
                            <p id="message-error" class="text-red-500 text-xs mt-1"></p>
                        </div>
                        
                        <div class="flex items-center">
                            <input id="newsletter" name="newsletter" type="checkbox" class="h-4 w-4 text-yellow-500 border-gray-700 rounded focus:ring-yellow-500">
                            <label for="newsletter" class="ml-2 block text-sm text-gray-300">
                                Subscribe to our newsletter for updates on new artworks and events
                            </label>
                        </div>
                        
                        <button type="submit" class="gradient-bg w-full py-4 rounded-lg font-bold text-lg safari-font hover:opacity-90 transition-opacity">SEND MESSAGE</button>
                    </form>
                </div>
                
                <!-- Map Column -->
                <div class="map-container h-full min-h-[400px] bg-gray-700">
                    <div class="h-96 lg:h-full w-full flex items-center justify-center bg-gray-700 rounded-xl">
                        <!-- Placeholder for map - would normally be an iframe or API integration -->
                        <div class="text-center p-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <h3 class="safari-font text-xl font-bold mb-3">OUR GALLERY LOCATION</h3>
                            <p class="text-gray-400">The Junction Mall<br>Nakuru, Kenya</p>
                            <div class="mt-6">
                                <p class="text-gray-300 mb-2"><span class="font-bold">HOURS:</span></p>
                                <p class="text-gray-400">Monday - Friday: 10:00 AM - 7:00 PM</p>
                                <p class="text-gray-400">Saturday: 11:00 AM - 6:00 PM</p>
                                <p class="text-gray-400">Sunday: 12:00 PM - 5:00 PM</p>
                            </div>
                            <a href="https://maps.google.com" target="_blank" class="inline-block gradient-bg px-6 py-2 rounded-full text-sm font-semibold neon-shadow mt-6 hover:opacity-90 transition-opacity safari-font">GET DIRECTIONS</a>
                        </div>
                    </div>
                </div>
            <a href="#" class="block max-w-sm w-full">
    <div class="mx-auto flex items-center gap-x-4 rounded-xl bg-white p-6 shadow-lg outline outline-black/5 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
      <img class="size-12 shrink-0" src="imgs/3.jpg" alt="ChitChat App Icon" />
      <div>
        
      </div>
    </div>
  </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 px-6 md:px-16">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="safari-font text-3xl md:text-4xl font-bold mb-2">FREQUENTLY <span class="text-red-400">ASKED</span> QUESTIONS</h2>
                <div class="w-24 h-1 gradient-bg mx-auto mt-4 mb-6"></div>
                <p class="text-gray-300">Find quick answers to common questions about our gallery and services</p>
            </div>
            
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-gray-800 rounded-xl p-6">
                    <h3 class="safari-font text-xl font-bold mb-3 flex items-center">
                        <span class="text-yellow-400 mr-3">Q:</span>
                        How can I purchase artwork from your gallery?
                    </h3>
                    <p class="text-gray-300 pl-8">You can purchase artworks directly through our website, by visiting our physical gallery location, or by contacting our sales team. We accept various payment methods and can arrange for shipping or local pickup.</p>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-gray-800 rounded-xl p-6">
                    <h3 class="safari-font text-xl font-bold mb-3 flex items-center">
                        <span class="text-yellow-400 mr-3">Q:</span>
                        Do you ship artwork internationally?
                    </h3>
                    <p class="text-gray-300 pl-8">Yes, we ship artwork globally. International shipping costs and delivery times vary based on the destination and artwork dimensions. Contact us for a detailed shipping quote for your specific location.</p>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-gray-800 rounded-xl p-6">
                    <h3 class="safari-font text-xl font-bold mb-3 flex items-center">
                        <span class="text-yellow-400 mr-3">Q:</span>
                        How can I submit my artwork to be featured in your gallery?
                    </h3>
                    <p class="text-gray-300 pl-8">We welcome submissions from talented artists. Please use our contact form to express your interest, and include links to your portfolio or attach sample images of your work. Our curatorial team reviews submissions monthly.</p>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-gray-800 rounded-xl p-6">
                    <h3 class="safari-font text-xl font-bold mb-3 flex items-center">
                        <span class="text-yellow-400 mr-3">Q:</span>
                        Do you offer art consultancy services?
                    </h3>
                    <p class="text-gray-300 pl-8">Yes, our team provides art consultancy services for private collectors, corporate clients, and interior designers. We can help you select artwork that matches your space, style preferences, and budget. Contact us to schedule a consultation.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Social Media Section -->
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
                    <a href="https://www.instagram.com/_k.o.s.h.e/" class="text-gray-400 hover:text-white transition-all duration-300 social-icon">
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
                    <li><a href="#" class="text-gray-400 hover:text-white transition-all duration-300">About Us</a></li>
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
            <p class="text-gray-500 text-sm mb-4 md:mb-0">&copy <?php echo date("Y"); ?> 2025 ART SAFARI. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-500 hover:text-gray-300 text-sm">Privacy</a>
                <a href="#" class="text-gray-500 hover:text-gray-300 text-sm">Terms</a>
                <a href="#" class="text-gray-500 hover:text-gray-300 text-sm">Sitemap</a>
                
            </div>
        </div>
    </div>
</footer>
<script>
    // Initialize cart from localStorage or create empty array
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    
    // Function to update the cart count displayed
    function updateCartCount() {
        const totalCount = cart.reduce((acc, item) => acc + item.quantity, 0);
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = totalCount;
        }
    }
  
    // Event listener for adding items to the cart
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize cart count on page load
        updateCartCount();
        
        // Add event listeners to all add-to-cart buttons
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", () => {
                const name = button.getAttribute("data-name");
                const price = parseFloat(button.getAttribute("data-price"));
                
                const existingItem = cart.find(item => item.name === name);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({ name, price, quantity: 1 });
                }
      
                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartCount(); // Update the cart count after adding an item
                alert(`${name} added to cart!`);
            });
        });
    });
</script>
</body>
</html>