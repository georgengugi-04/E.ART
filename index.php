<?php
session_start();
include("config/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HE-ART | Discover & Collect Art</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        
        .safari-font {
            font-family: 'Orbitron', sans-serif;
        }
        html {
            scroll-behavior: smooth;
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
          background: linear-gradient(-45deg, #2b1a1a, #5c3a3a, #b76e79, #e8a798);
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
        :root {
            --primary-color:hsl(27, 92.60%, 47.80%);
            --secondary-color:hsl(0, 91.30%, 44.90%);
            --background-dark:#0afd53;
            --text-light: #f8fafc;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-dark);
            color: var(--text-light);
            line-height: 1.6;
            scroll-behavior: smooth;
        }
        .gradient-text {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .shape-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }
        .shape-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }
        .glassmorphism {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .playfair {
            font-family: 'Playfair Display', serif;
        }
        
        
        .project-card {
            transition: transform 0.3s ease;
        }
        .project-card:hover {
            transform: translateY(-10px);
        }
        .contact-icon {
            width: 50px;
            height: 50px;
            margin-right: 16px;
            color: #fff;
        }
   .animated-gradient {
 background: linear-gradient(-45deg, #2b1a1a, rgba(12, 11, 14, 1), #050304ff, rgba(97, 18, 0, 1));
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }
        
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 6s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 8s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 10s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 12s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 14s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 16s; }
        
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
        
        /* Modern glassmorphism navbar */
        .glass-nav {
            background: rgba(15, 15, 35, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        /* Gradient text effects */
        .gradient-text-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .gradient-text-accent {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Glowing button effects */
        .glow-button {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 16px 32px;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .glow-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="animated-gradient min-h-screen">
    <!-- Floating particles background -->
    <div class="particles fixed inset-0 z-0">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <nav class="fixed w-full z-50 glassmorphism">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center">
                        <span class="text-4xl font-black uppercase tracking-wider gradient-text">E_ARTGALLA</span>
                        <div class="hidden md:flex space-x-8 ml-12">
                            <a href="index.php" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Home</a>
                            <a href="collections.html" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Marketplace</a>
                            <a href="artists.html" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Artists</a>

                            <a href="about.html" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">About</a>
                            <a href="contact.php" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Contact</a>
                               <a href="gallery.html" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Gallery</a>
                            <a href="submi.php" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Submit Art</a>
                             <a href="cart.php" class="border-green-500 text-white border-b-2 px-1 pt-1 text-sm font-medium">
                            Cart (<span id="cart-count">0</span>)
                        </a>
                        </div>
                    </div>
                   
                       
                        <div class="hidden md:block">
                            <a href="contact.php" class="px-6 py-3 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition-colors font-semibold">Get Started</a>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
   
    
    
    <!-- Hero Section -->
 <section class="relative min-h-[80vh] flex items-center justify-center pt-16 px-4 sm:px-6 lg:px-8">

        <!-- Floating decorative elements -->
        <div class="floating-element absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 opacity-20 blur-3xl"></div>
        <div class="floating-element absolute bottom-1/4 right-1/4 w-24 h-24 rounded-full bg-gradient-to-r from-blue-400 to-purple-400 opacity-20 blur-2xl"></div>
        
        <div class="max-w-7xl mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="hero-content relative z-10">
                    <div class="hero-card">
                        <h1 class="text-5xl lg:text-7xl font-black mb-6 leading-tight">
                            <span class="text-white">DISCOVER</span><br>
                            <span class="gradient-text-accent">EXTRAORDINARY</span><br>
                            <span class="gradient-text-primary">ART</span>
                        </h1>
                        
                        <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                            Immerse yourself in a world of creativity where every piece tells a story. 
                            Connect with visionary artists and collect masterpieces that speak to your soul.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 mb-8">
                           <a href="gallery.html" class="bg-transparent border-2 border-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all safari-font">
                                Explore gallery 
    </a>
                            <a href="artists.html" class="bg-transparent border-2 border-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all safari-font">
                                Meet Artists
    </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-700">
                            <div class="text-center">
                                <div class="text-2xl font-bold gradient-text-primary">500+</div>
                                <div class="text-gray-400 text-sm">Artworks</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold gradient-text-accent">150+</div>
                                <div class="text-gray-400 text-sm">Artists</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-400">12K+</div>
                                <div class="text-gray-400 text-sm">Collectors</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Image -->
            <div class="relative">
  <div class="hero-image w-40 h-40 sm:w-48 sm:h-48">
    <img src="imgs/2.jpg" 
         alt="Modern Art Gallery" 
         class="w-full h-full object-cover rounded-lg shadow-md">
  </div>
</div>

                    <!-- Floating info cards -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-4 shadow-2xl max-w-xs floating-element">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">Featured Artist</div>
                                <div class="text-sm text-gray-600">George Ngugi</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -top-6 -right-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl p-4 shadow-2xl floating-element">
                        <div class="text-white text-center">
                            <div class="text-2xl font-bold">12.5K</div>
                            <div class="text-sm opacity-90">Latest Sale</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <div class="animate-bounce">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </section>
    
   
    <!-- Art section -->
    <section class="py-16 px-6">
        <div class="relative z-20 flex flex-col items-center justify-center text-center">
            <h2 class="safari-font text-4xl md:text-6xl lg:text-7xl font-bold mb-4">
                <span class="text-yellow-400">DISCOVER</span> & <span class="text-red-400">COLLECT</span>
            </h2>
            <p class="text-xl md:text-2xl max-w-2xl mb-8">Embark on an artistic journey through extraordinary creations from emerging and established artists</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="collections.html" class="gradient-bg px-8 py-3 rounded-full text-lg font-semibold neon-shadow hover:opacity-60 transition-opacity safari-font">EXPLORE ART</a>
                <a href="artists.html" class="bg-transparent border-2 border-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all safari-font">MEET ARTISTS</a>
            </div>
        </div>
    </section>

    <!-- Add mobile menu script -->
    <script>
        // Mobile menu toggle functionality
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            // Add mobile menu functionality here
            console.log('Mobile menu toggled');
            // Implementation would go here
        });
    </script>

   
    
    

    <!-- Featured Art Section -->
    <section id="artworks" class="py-20 px-6 md:px-16">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="safari-font text-3xl md:text-5xl font-bold mb-2">FEATURED <span class="text-yellow-400">ARTWORKS</span></h2>
            <div class="w-24 h-1 gradient-bg mx-auto mt-4 mb-6"></div>
            <p class="max-w-3xl mx-auto text-gray-300 text-lg">Discover unique pieces that speak to your soul</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Artwork Cards -->
            <div class="bg-gray-800 rounded-xl p-6 transition-all duration-300">
                <div class="h-64 mb-6 rounded-lg overflow-hidden">
                    <img src="imgs/1.jpeg" alt="Abstract Painting" class="w-full h-full object-cover">
                </div>
                <h3 class="safari-font text-xl font-bold mb-2">COSMIC DREAMS</h3>
                <p class="text-yellow-400 mb-3">By John Njoroge</p>
                <p class="text-gray-300 mb-4">Abstract acrylic painting exploring the boundaries between dreams and reality.</p>
                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold">12,500</span>
                    <button class="add-to-cart gradient-bg px-4 py-2 rounded-full text-sm font-semibold neon-shadow" 
                           data-name="Cosmic Dreams" 
                           data-price="12500">ACQUIRE</button>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-6 transition-all duration-300">
                <div class="h-64 mb-6 rounded-lg overflow-hidden">
                    <img src="imgs/1.jpg" alt="Sculpture" class="w-full h-full object-cover">
                </div>
                <h3 class="safari-font text-xl font-bold mb-2">AZURE SERENITY</h3>
                <p class="text-yellow-400 mb-3">By Kinywa</p>
                <p class="text-gray-300 mb-4">Bronze sculpture capturing the fluidity of water in solid form.</p>
                <div class="flex items-center justify-between">
                    <span class="price text-xl font-bold">14,800</span>
                    <button class="add-to-cart gradient-bg px-4 py-2 rounded-full text-sm font-semibold neon-shadow" 
                           data-name="Azure Serenity" 
                           data-price="14800">ACQUIRE</button>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-6 transition-all duration-300">
                <div class="h-64 mb-6 rounded-lg overflow-hidden">
                    <img src="imgs/3.jpg" alt="Digital Art" class="w-full h-full object-cover">
                </div>
                <h3 class="safari-font text-xl font-bold mb-2">NEURAL PATHWAYS</h3>
                <p class="text-yellow-400 mb-3">By Lenny Kariuki</p>
                <p class="text-gray-300 mb-4">Digital artwork exploring the intersection of technology and human consciousness.</p>
                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold">11,750</span>
                    <button class="add-to-cart gradient-bg px-4 py-2 rounded-full text-sm font-semibold neon-shadow" 
                           data-name="Neural Pathways" 
                           data-price="11750">ACQUIRE</button>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="collections.html" class="inline-block border-2 border-yellow-400 text-yellow-400 px-8 py-3 rounded-full safari-font hover:bg-yellow-400 hover:text-gray-900 transition-all">VIEW ALL ARTWORKS</a>
        </div>
    </div>
</section>

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
    <section id="categories" class="py-16 md:py-24 relative">
        <div class="absolute inset-0 z-0">
            <img src="imgs/s.jpeg" alt="Kenyan Art Background" class="w-full h-full object-cover opacity-60" />
            <div class="absolute inset-0 bg-gradient-to-br from-black via-transparent to-black opacity-80"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="playfair text-4xl md:text-5xl font-bold text-white">Explore Kenyan Art</h2>
                <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto inter">Find your perfect piece through our curated Kenyan art categories</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="category-card bg-black bg-opacity-50 backdrop-filter backdrop-blur-md rounded-xl p-6 text-center transition transform hover:scale-105 border border-green-900">
                    <div class="w-16 h-16 mx-auto bg-green-700 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 playfair">Maasai Art</h3>
                    <p class="text-gray-300 inter">Traditional beadwork and vibrant patterns</p>
                </div>
                
                <div class="category-card bg-black bg-opacity-50 backdrop-filter backdrop-blur-md rounded-xl p-6 text-center transition transform hover:scale-105 border border-green-900">
                    <div class="w-16 h-16 mx-auto bg-red-700 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 playfair">Contemporary</h3>
                    <p class="text-gray-300 inter">Modern Kenyan creative expressions</p>
                </div>
                
                <div class="category-card bg-black bg-opacity-50 backdrop-filter backdrop-blur-md rounded-xl p-6 text-center transition transform hover:scale-105 border border-green-900">
                    <div class="w-16 h-16 mx-auto bg-yellow-600 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h6a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM9 3v7m0-0c0 1.609-2.343 2.907-4 3M15 17v2a2 2 0 002 2h2a2 2 0 002-2v-7a2 2 0 00-2-2h-4a2 2 0 00-2 2v7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 playfair">Kisii Soapstone</h3>
                    <p class="text-gray-300 inter">Hand-carved stone sculptures</p>
                </div>
                
                <div class="category-card bg-black bg-opacity-50 backdrop-filter backdrop-blur-md rounded-xl p-6 text-center transition transform hover:scale-105 border border-green-900">
                    <div class="w-16 h-16 mx-auto bg-black rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-4c0-1.519-1.236-2.807-2.764-3.091M19 17v-4c0-1.519-1.236-2.807-2.764-3.091M3 11h16v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6zM15 10v2a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2a1 1 0 011-1h2a1 1 0 011 1z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 playfair">Kikoi Textiles</h3>
                    <p class="text-gray-300 inter">Traditional fabric art and designs</p>
                </div>
            </div>
        
            <div class="text-center mt-12">
                <a href="gallery.html" class="px-8 py-3 bg-green-800 hover:bg-green-700 text-white rounded-lg font-bold transition transform hover:scale-105 inter">
                    Explore All Categories
</a>
            </div>
        </div>
    </section>

  
            
   

    <!-- Art Categories Section -->
    <section class="py-20 px-6 md:px-16 bg-gray-800">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="safari-font text-3xl md:text-5xl font-bold mb-2"><span class="text-red-400">ART</span> CATEGORIES</h2>
                <div class="w-24 h-1 gradient-bg mx-auto mt-4 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-300 text-lg">Explore different styles and mediums from our diverse collection</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="relative rounded-xl overflow-hidden h-64 group">
                    <img src="imgs/4.jpg" alt="Paintings" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="safari-font text-xl font-bold mb-1">PAINTINGS</h3>
                        <p class="text-gray-300 text-sm">6 artworks</p>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden h-64 group">
                    <img src="imgs/d.jpeg" alt="Sculptures" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="safari-font text-xl font-bold mb-1">SCULPTURES</h3>
                        <p class="text-gray-300 text-sm">8 artworks</p>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden h-64 group">
                    <img src="imgs/s.jpeg" alt="Digital Art" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="safari-font text-xl font-bold mb-1">DIGITAL ART</h3>
                        <p class="text-gray-300 text-sm">4 artworks</p>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden h-64 group">
                    <img src="imgs/abstract-elegance-6-.jpeg" alt="Photography" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="safari-font text-xl font-bold mb-1">PHOTOGRAPHY</h3>
                        <p class="text-gray-300 text-sm">7 artworks</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Artists Section -->

    <section id="artists" class="py-20 px-6 md:px-16">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="safari-font text-3xl md:text-5xl font-bold mb-2">FEATURED <span class="text-yellow-400">ARTISTS</span></h2>
                <div class="w-24 h-1 gradient-bg mx-auto mt-4 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-300 text-lg">Meet the creative minds behind the extraordinary artworks</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                
                <!-- Artist Cards -->
                <div class="bg-gray-800 rounded-xl overflow-hidden transition-transform hover:transform hover:scale-105">
                    <div class="h-64 overflow-hidden">
                        <img src="imgs/c.jpg" alt="Artist" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="safari-font text-xl font-bold mb-1">BENARD KARUMA</h3>
                        <p class="text-yellow-400 mb-3">Abstract Expressionist</p>
                        <p class="text-sm text-gray-300">Creating vibrant emotional landscapes through color and form .Best graphic text guy in town</p>
                    </div>
                </div>
                
                <div class="bg-gray-800 rounded-xl overflow-hidden transition-transform hover:transform hover:scale-105">
                    <div class="h-64 overflow-hidden">
                        <img src="imgs/v.jpg" alt="Artist" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="safari-font text-xl font-bold mb-1"></h3>FREDRICK KAMAU</h3>
                        <p class="text-red-400 mb-3">Sales Manager </p>
                        <p class="text-sm text-gray-300">Transforming  into flowing organic forms . </p>
                    </div>
                </div>
                
                <div class="bg-gray-800 rounded-xl overflow-hidden transition-transform hover:transform hover:scale-105">
                    <div class="h-64 overflow-hidden">
                        <img src="imgs/we.jpg" alt="Artist" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="safari-font text-xl font-bold mb-1">GEORGE NGUGI</h3>
                        <p class="text-yellow-400 mb-3">Digital Artist</p>
                        <p class="text-sm text-gray-300">Blending technology and traditional art techniques</p>
                    </div>
                </div>
                
                <div class="bg-gray-800 rounded-xl overflow-hidden transition-transform hover:transform hover:scale-105">
                    <div class="h-64 overflow-hidden">
                        <img src="imgs/we.jpg" alt="Artist" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="safari-font text-xl font-bold mb-1">DAVID OKAFOR</h3>
                        <p class="text-red-400 mb-3">Photographer</p>
                        <p class="text-sm text-gray-300">Capturing the beauty of urban landscapes and human stories</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="artists.html" class="inline-block border-2 border-red-400 text-red-400 px-8 py-3 rounded-full safari-font hover:bg-red-400 hover:text-gray-900 transition-all">MEET ALL ARTISTS</a>
            </div>
        </div>
    </section>

    <!-- Sell Art Section -->
    <section class="py-20 px-6 md:px-16 bg-gray-800 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full opacity-10">
            <img src="4.jpg" alt="Decorative Art" class="w-full h-full object-cover">
        </div>
        
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="safari-font text-3xl md:text-5xl font-bold mb-6">SHARE YOUR <span class="text-yellow-400">CREATION</span> WITH THE WORLD</h2>
                    <p class="text-gray-300 mb-8">Join our community of artists and showcase your work to art lovers and collectors worldwide. Art Safari provides a platform for artists at all stages of their careers.</p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center"><span class="text-yellow-400 mr-3">✓</span> Easy setup with artist profile and portfolio</li>
                        <li class="flex items-center"><span class="text-yellow-400 mr-3">✓</span> Global audience of collectors and enthusiasts</li>
                        <li class="flex items-center"><span class="text-yellow-400 mr-3">✓</span> Secure payment processing</li>
                        <li class="flex items-center"><span class="text-yellow-400 mr-3">✓</span> Marketing and promotion opportunities</li>
                    </ul>
                    <a href="submi.php" class="gradient-bg px-8 py-3 rounded-full text-lg font-semibold neon-shadow inline-block hover:opacity-90 transition-opacity safari-font">START SELLING</a>
                </div>
                
                
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="py-20 px-6 md:px-16">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="safari-font text-3xl md:text-5xl font-bold mb-2">UPCOMING <span class="text-red-400">EVENTS</span></h2>
                <div class="w-24 h-1 gradient-bg mx-auto mt-4 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-300 text-lg">Join us for exhibitions, workshops, and artist talks</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-800 rounded-xl overflow-hidden">
                    <div class="h-64 relative">
                        <img src="imgs/a.jpg" alt="Exhibition" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-4 py-1 rounded safari-font">APR 15</div>
                    </div>
                    <div class="p-6">
                        <h3 class="safari-font text-xl font-bold mb-2">EMERGING VISIONS: NEW ARTIST SHOWCASE</h3>
                        <p class="text-gray-300 mb-4">A spotlight on the most exciting new talent in contemporary art. Join us for the opening reception and meet the artists.</p>
                        <div class="flex items-center text-sm text-gray-400 mb-6">
                            <span class="mr-4">📍 Art Safari Gallery</span>
                            <span>🕖 6:00 PM - 9:00 PM</span>
                        </div>
                        <a href="#" class="gradient-bg px-6 py-2 rounded-full text-sm font-semibold neon-shadow inline-block hover:opacity-90 transition-opacity safari-font">RSVP</a>
                    </div>
                </div>
                
                <div class="bg-gray-800 rounded-xl overflow-hidden">
                    <div class="h-64 relative">
                        <img src="imgs/2.jpeg" alt="Workshop" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-4 py-1 rounded safari-font">APR 22</div>
                    </div>
                    <div class="p-6">
                        <h3 class="safari-font text-xl font-bold mb-2">DIGITAL ART MASTERCLASS WITH AISHA JOHNSON</h3>
                        <p class="text-gray-300 mb-4">Learn cutting-edge digital art techniques from one of our featured artists. Limited spots available.</p>
                        <div class="flex items-center text-sm text-gray-400 mb-6">
                            <span class="mr-4">📍 Online Workshop</span>
                            <span>🕖 2:00 PM - 5:00 PM</span>
                        </div>
                        <a href="#" class="gradient-bg px-6 py-2 rounded-full text-sm font-semibold neon-shadow inline-block hover:opacity-90 transition-opacity safari-font">REGISTER</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Collector Testimonials -->
    <section class="py-20 px-6 md:px-16 bg-gray-800">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="safari-font text-3xl md:text-5xl font-bold mb-2">ART <span class="text-yellow-400">COLLECTORS</span> SAY</h2>
                <div class="w-24 h-1 gradient-bg mx-auto mt-4 mb-6"></div>
                <p class="max-w-3xl mx-auto text-gray-300 text-lg">Hear from those who have found their perfect pieces</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-900 p-6 rounded-xl relative">
                    <div class="text-5xl text-yellow-500 absolute -top-4 left-4 opacity-50">"</div>
                    <p class="text-gray-300 mb-4 pt-6">Art Safari introduced me to artists I never would have discovered otherwise. The piece I purchased has become the focal point of my living room and sparks conversation with every visitor.</p>
                    <div class="flex items-center mt-4">
                        <div class="w-12 h-12 rounded-full bg-gray-600 mr-4"></div>
                        <div>
                            <p class="font-bold">Michael L.</p>
                            <p class="text-sm text-gray-400">Art Collector</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-900 p-6 rounded-xl relative">
                    <div class="text-5xl text-yellow-500 absolute -top-4 left-4 opacity-50">"</div>
                    <p class="text-gray-300 mb-4 pt-6">The curation on this platform is exceptional. I've found pieces that resonate with me on a deep level, and the process of acquiring them has been seamless and transparent.</p>
                    <div class="flex items-center mt-4">
                        <div class="w-12 h-12 rounded-full bg-gray-600 mr-4"></div>
                        <div>
                            <p class="font-bold">Sophia T.</p>
                            <p class="text-sm text-gray-400">Interior Designer</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-900 p-6 rounded-xl relative">
                    <div class="text-5xl text-yellow-500 absolute -top-4 left-4 opacity-50">"</div>
                    <p class="text-gray-300 mb-4 pt-6">As someone new to collecting art, I appreciated the detailed information about each artwork and artist. It helped me make informed decisions and build a small collection I'm proud of.</p>
                    <div class="flex items-center mt-4">
                        <div class="w-12 h-12 rounded-full bg-gray-600 mr-4"></div>
                        <div>
                            <p class="font-bold">James K.</p>
                            <p class="text-sm text-gray-400">First-time Collector</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="fixed inset-0 z-50 bg-black/95 hidden">
        <div class="flex justify-end p-6">
            <button id="close-mobile-menu" class="text-white focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center justify-center h-full   bg-gray-500  bg-opacity-80  " >
            <div class="w-24 h-1 gradient-bg mb-6"></div>
            <h2 class="safari-font text-3xl font-bold text-white mb-6">MENU</h2>
            <div class="w-24 h-1 gradient-bg mb-6"></div>
            <a href="index.html" class="text-3xl font-semibold text-white mb-8 hover:text-emerald-400">Home</a>
            <a href="collection.html" class="text-3xl font-semibold text-white mb-8 hover:text-emerald-400">Marketplace</a>
            <a href="artists.html" class="text-3xl font-semibold text-white mb-8 hover:text-emerald-400">Artists</a>
            <a href="gallery.html" class="text-3xl font-semibold text-white mb-8 hover:text-emerald-400">Gallery</a>
            <a href="contact.php" class="text-3xl font-semibold text-white mb-8 hover:text-emerald-400">Contact</a>
            <a href="submi.php" class="text-3xl font-semibold text-white mb-8 hover:text-emerald-400">Submit art</a>
             <a href="cart.php" class="border-green-500 text-white border-b-2 px-1 pt-1 text-sm font-medium">
                            Cart (<span id="cart-count">0</span>)
                        </a>
            
            <a href="contact.php" class="mt-4 px-8 py-3 bg-orange-600 text-blue rounded-full hover:bg-red-700 transition-colors font-semibold">Get Started</a>
        </div>
    </div>

    <!-- Add a semi-transparent overlay for page transitions -->
    <div id="page-transition" class="fixed inset-0 bg-black opacity-0 pointer-events-none z-[100] transition-opacity duration-500"></div>

    <script>
        // Mobile menu functionality
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenu = document.getElementById('close-mobile-menu');
        
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
        
        closeMobileMenu.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        // Close mobile menu when clicking a navigation link
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add page transition effect
                const pageTransition = document.getElementById('page-transition');
                pageTransition.classList.add('opacity-50');
                pageTransition.classList.remove('pointer-events-none');
                
                setTimeout(() => {
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                    
                    // Remove transition effect
                    setTimeout(() => {
                        pageTransition.classList.remove('opacity-50');
                        pageTransition.classList.add('pointer-events-none');
                    }, 300);
                }, 300);
            });
        });

        // Parallax effect for header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            const scrollPosition = window.scrollY;
            header.style.backgroundPositionY = `${scrollPosition * 0.5}px`;
        });

        // Intersection Observer for revealing elements on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });

        // Add animation classes
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes fadeIn {
                    from { opacity: 90; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fadeIn {
                    animation: fadeIn 0.8s ease forwards;
                }
                section {
                    opacity: 60;
                }
            </style>
        `);
    </script>


    <!-- Newsletter Section -->
 
    <section class="py-20 px-6 md:px-16 bg-gray-900 relative" id="newsletter-section">
    <div class="absolute inset-0 opacity-10">
        <img src="imgs/1.jpeg" alt="Background Pattern" class="w-full h-full object-cover">
    </div>
    <?php
    if (isset($_GET['msg'])) {
        $messages = [
            'success' => "Subscription successful!",
            'exists' => "Email address already subscribed.",
            'invalid' => "Invalid email format.",
            'error' => "Something went wrong. Please try again."
        ];
        $msgType = $_GET['msg'];
        if (array_key_exists($msgType, $messages)) {
            echo '<p class="text-white bg-gray-700 p-4 rounded mt-4">' . $messages[$msgType] . '</p>';
        }
    }
    ?>

    <div class="max-w-4xl mx-auto relative z-10">
        <div class="text-center mb-10">
            <h2 class="safari-font text-3xl md:text-4xl font-bold mb-2">STAY IN THE <span class="text-red-400">LOOP</span></h2>
            <p class="max-w-2xl mx-auto text-gray-300">Subscribe to our newsletter for the latest exhibitions, artist spotlights, and exclusive invitations</p>
        </div>
        <form method="POST" action="configs/subscribers.php#newsletter-section" class="mb-8" id="newsletter-form">
            <input type="hidden" name="form_type" value="newsletter">
            <input type="hidden" name="form_source" value="footer">
            <div class="flex flex-col md:flex-row gap-4">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Your email address" 
                    class="flex-grow bg-gray-800 border border-gray-700 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required
                >
                <button 
                    class="gradient-bg px-8 py-3 rounded-lg font-semibold neon-shadow hover:opacity-90 transition-opacity safari-font whitespace-nowrap"
                >
                    SUBSCRIBE
                </button>
            </div>
            <p class="text-gray-400 text-sm">We respect your privacy. Unsubscribe at any time.</p>
        </form>
    </div>
</section>


    <!-- Footer -->
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
                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Join Our Newsletter</h4>
                    <p class="text-gray-400 mb-4">Stay updated with new art, exhibitions, and exclusive offers.</p>
                    <form class="space-y-3">
                        <div class="relative">
                            <input type="email" placeholder="Your email address" class="w-full px-4 py-3 bg-transparent input-gradient rounded-lg border border-gray-700 focus:border-gray-500 focus:outline-none text-gray-300">
                        </div>
                        <button type="submit" class="w-full px-4 py-3 btn-gradient rounded-lg text-white font-medium">Subscribe</button>
                    </form>
                </div>
            </div>

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
     
      
        const form = document.getElementById('contact-form');

function validateForm() {
    let isValid = true;

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();

    // Validate name
    isValid &= validateField(name, 'name-error', 'Your Name is required');
    
    // Validate email
    isValid &= validateEmail(email, 'email-error');

    return isValid;
}

function validateField(value, errorId, errorMessage) {
    const errorElement = document.getElementById(errorId);
    if (!value) {
        errorElement.textContent = errorMessage;
        return false;
    } else {
        errorElement.textContent = '';
        return true;
    }
}

function validateEmail(email, errorId) {
    const errorElement = document.getElementById(errorId);
    const emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    if (!email) {
        errorElement.textContent = 'Your Email is required';
        return false;
    } else if (!emailRegex.test(email)) {
        errorElement.textContent = 'Invalid email format';
        return false;
    } else {
        errorElement.textContent = '';
        return true;
    }
}

form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (validateForm()) {
        alert('Message sent successfully! We will get back to you soon.');
        form.reset();
    }
});

    const urlParams = new URLSearchParams(window.location.search);
    const msg = urlParams.get('msg');
    if (msg) {
        const messageMap = {
            success: "Subscription successful!",
            exists: "Email address already subscribed.",
            invalid: "Invalid email format.",
            error: "Something went wrong. Please try again.",
        };

        const message = messageMap[msg] || "Unknown status.";
        const messageContainer = document.createElement("p");
        messageContainer.className = "text-white bg-gray-700 p-4 rounded mt-4";
        messageContainer.innerText = message;
        document.querySelector("form").after(messageContainer);
    }
const cart = JSON.parse(localStorage.getItem("cart")) || [];

  
</script>

</body>
</html>