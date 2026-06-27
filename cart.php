<?php
// Start session only once
session_start();

// Include database connection
include("config/connect.php");

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Add item to cart
    if ($action === 'add' && isset($_POST['name']) && isset($_POST['price'])) {
        $name = htmlspecialchars($_POST['name']);
        $price = floatval($_POST['price']);
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
        // Check if item already exists in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $name) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        // Add new item if not found
        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity
            ];
        }
        
        // Return JSON response for AJAX requests
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
            exit;
        }
    }
    
    // Update quantity
    else if ($action === 'update' && isset($_POST['index']) && isset($_POST['quantity'])) {
        $index = intval($_POST['index']);
        $quantity = intval($_POST['quantity']);
        
        if (isset($_SESSION['cart'][$index])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$index]['quantity'] = $quantity;
            } else {
                // Remove item if quantity is 0 or negative
                array_splice($_SESSION['cart'], $index, 1);
            }
        }
        
        // Return JSON response for AJAX requests
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
            exit;
        }
    }
    
    // Remove item
    else if ($action === 'remove' && isset($_POST['index'])) {
        $index = intval($_POST['index']);
        
        if (isset($_SESSION['cart'][$index])) {
            array_splice($_SESSION['cart'], $index, 1);
        }
        
        // Return JSON response for AJAX requests
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
            exit;
        }
    }
    
    // Clear cart
    else if ($action === 'clear') {
        $_SESSION['cart'] = [];
        
        // Return JSON response for AJAX requests
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
            exit;
        }
    }
    
    // Redirect to cart page after handling POST actions
    header('Location: cart.php');
    exit;
}

// Calculate cart totals
$cartCount = 0;
$subtotal = 0;

foreach ($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity'];
    $subtotal += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | ART SAFARI</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        
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

        .btn-gradient {
            background: linear-gradient(90deg, #f59e0b, #ef4444);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            filter: brightness(1.1);
        }

        .input-gradient:focus {
            box-shadow: 0 0 0 2px rgba(8, 7, 4, 0.3);
        }

        .cart-item {
            border-bottom: 1px solid #2d2d2d;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .glassmorphism {
            background-color: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        footer {
            background: #0a0a0a;
            padding: 50px;
            margin-top: 50px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }
        
        .footer-column h3 {
            color: #00ff88;
            margin-bottom: 20px;
        }
        
        .footer-column ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-column ul li a:hover {
            color: #00ff88;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icons a {
            color: #fff;
            font-size: 20px;
            transition: color 0.3s ease;
        }
        
        .social-icons a:hover {
            color: #00ff88;
        }
        
        .copyright {
            margin-top: 50px;
            text-align: center;
            color: #666;
            padding-top: 20px;
            border-top: 1px solid #1a1a1a;
        }

        .empty-cart {
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <body class="bg-gray-900 text-white">
    <!-- Fixed header section -->
    <header >
        <div class="absolute inset-0 bg-black/70"></div>
        
        <!-- Navigation bar -->
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
                            <a href="submi.php" class="text-slate-300 hover:text-emerald-400 transition-colors font-semibold">Submit Art</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="cart.php" class="border-green-500 text-white border-b-2 px-1 pt-1 text-sm font-medium">
                            Cart (<span id="cart-count">0</span>)
                        </a>
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
       
    </header>
    
    <!-- Cart Section -->
    <section class="px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Empty Cart Message (displayed when cart is empty) -->
            <div id="empty-cart" class="empty-cart hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-500 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-semibold mb-3">Your cart </h2>
                <p class="text-gray-400 mb-6">Looks like you haven't added any artwork to your cart .</p>
                <a href="collections.html" class="btn-gradient px-6 py-3 rounded-lg font-medium">Explore Artwork</a>
            </div>

            <!-- Cart Items -->
            <div id="cart-content" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-4 px-2">Artwork</th>
                                <th class="text-center py-4 px-2">Price</th>
                                <th class="text-center py-4 px-2">Quantity</th>
                                <th class="text-right py-4 px-2">Total</th>
                                <th class="text-right py-4 px-2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <!-- Cart items will be inserted here via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Cart Summary -->
                <div class="mt-10 flex flex-col md:flex-row justify-between items-start">
                    <!-- Coupon Code -->
                    <div class="w-full md:w-1/2 mb-8 md:mb-0 md:pr-8">
                        <h3 class="text-xl font-semibold mb-4">Have a coupon?</h3>
                        <div class="flex">
                            <input type="text" placeholder="Enter coupon code" class="flex-grow px-4 py-3 bg-transparent rounded-l-lg border border-gray-700 focus:border-gray-500 focus:outline-none text-gray-300 input-gradient">
                            <button class="btn-gradient px-6 py-3 rounded-r-lg text-white font-medium">Apply</button>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full md:w-1/2 bg-gray-800 bg-opacity-50 rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Subtotal</span>
                                <span id="subtotal">0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Shipping</span>
                                <span id="shipping">Calculated at checkout</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Tax</span>
                                <span id="tax">Calculated at checkout</span>
                            </div>
                            <div class="border-t border-gray-700 pt-3 mt-3">
                                <div class="flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span id="total" class="text-yellow-400">0.00</span>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="window.location.href='checkout.php'" class="w-full btn-gradient rounded-lg text-white font-medium py-3 mt-6">
                            Proceed to Checkout
                        </button>
                        
                        <button id="clear-cart-btn" class="w-full bg-transparent border border-gray-600 hover:border-gray-500 rounded-lg text-gray-300 font-medium py-3 mt-3">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- You Might Also Like Section -->
    <section class="px-4 py-12 bg-black bg-opacity-30">
        <div class="max-w-6xl mx-auto">
            <h2 class="safari-font text-3xl font-bold mb-10">YOU MIGHT ALSO <span class="text-yellow-400">LIKE</span></h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Suggestion 1 -->
                <div class="artwork-card rounded-lg overflow-hidden">
                    <img src="imgs/4.jpg" alt="Suggested Artwork" class="w-full h-48 object-cover">
                    <div class="p-4 bg-gray-800">
                        <h3 class="font-semibold text-lg">Mystic Mountains</h3>
                        <p class="text-gray-400">By James Chen</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-yellow-400 font-bold">11,890</span>
                            <button class="btn-gradient px-3 py-1 rounded text-sm font-medium add-to-cart" 
                                    data-name="Mystic Mountains" 
                                    data-price="1890">Add to Cart</button>
                        </div>
                    </div>
                </div>
                
                <!-- Suggestion 2 -->
                <div class="artwork-card rounded-lg overflow-hidden">
                    <img src="imgs/1.jpg" alt="Suggested Artwork" class="w-full h-48 object-cover">
                    <div class="p-4 bg-gray-800">
                        <h3 class="font-semibold text-lg">Serene Wilderness</h3>
                        <p class="text-gray-400">By Aisha Patel</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-yellow-400 font-bold">12,450</span>
                            <button class="btn-gradient px-3 py-1 rounded text-sm font-medium add-to-cart" 
                                    data-name="Serene Wilderness" 
                                    data-price="2450">Add to Cart</button>
                        </div>
                    </div>
                </div>
                
                <!-- Suggestion 3 -->
                <div class="artwork-card rounded-lg overflow-hidden">
                    <img src="imgs/3.jpg" alt="Suggested Artwork" class="w-full h-48 object-cover">
                    <div class="p-4 bg-gray-800">
                        <h3 class="font-semibold text-lg">Urban Dreams</h3>
                        <p class="text-gray-400">By Maya Rosen</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-yellow-400 font-bold">11,750</span>
                            <button class="btn-gradient px-3 py-1 rounded text-sm font-medium add-to-cart" 
                                    data-name="Urban Dreams" 
                                    data-price="1750">Add to Cart</button>
                        </div>
                    </div>
                </div>
                                <!-- Suggestion 4 -->
                <div class="artwork-card rounded-lg overflow-hidden">
                    <img src="imgs/2.jpeg" alt="Suggested Artwork" class="w-full h-48 object-cover">
                    <div class="p-4 bg-gray-800">
                        <h3 class="font-semibold text-lg">Abstract Vision</h3>
                        <p class="text-gray-400">By Leo Fernandez</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-yellow-400 font-bold">13,200</span>
                            <button class="btn-gradient px-3 py-1 rounded text-sm font-medium add-to-cart" 
                                    data-name="Abstract Vision" 
                                    data-price="3200">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 pt-16 pb-8 px-6 md:px-16 border-t border-gray-800">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-16">
                <!-- Company Info -->
                <div>
                    <div class="gradient-bg p-2 rounded-lg neon-shadow inline-block mb-4">
                        <h3 class="safari-font font-bold text-xl text-white">E-GALLA</h3>
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
         let cart = JSON.parse(localStorage.getItem("cart")) || [];

const cartCount = document.getElementById("cart-count");
const cartItemsContainer = document.getElementById("cart-items");
const cartContent = document.getElementById("cart-content");
const emptyCart = document.getElementById("empty-cart");
const subtotalDisplay = document.getElementById("subtotal");
const totalDisplay = document.getElementById("total");

function updateCart() {
  cartItemsContainer.innerHTML = "";

  if (cart.length === 0) {
    cartContent.classList.add("hidden");
    emptyCart.classList.remove("hidden");
    cartCount.innerText = "0";
    subtotalDisplay.textContent = "$0.00";
    totalDisplay.textContent = "$0.00";
    return;
  }

  cartContent.classList.remove("hidden");
  emptyCart.classList.add("hidden");

  let subtotal = 0;
  cart.forEach((item, index) => {
    const itemTotal = item.price * item.quantity;
    subtotal += itemTotal;

    const row = document.createElement("tr");
    row.classList.add("cart-item");
    row.innerHTML = `
      <td class="py-4 px-2">${item.name}</td>
      <td class="text-center py-4 px-2">$${item.price.toFixed(2)}</td>
      <td class="text-center py-4 px-2">
        <div class="flex justify-center items-center gap-2">
          <button class="quantity-btn" onclick="changeQuantity(${index}, -1)">-</button>
          <span>${item.quantity}</span>
          <button class="quantity-btn" onclick="changeQuantity(${index}, 1)">+</button>
        </div>
      </td>
      <td class="text-right py-4 px-2">$${itemTotal.toFixed(2)}</td>
      <td class="text-right py-4 px-2">
        <button class="text-red-400 hover:text-red-200" onclick="removeItem(${index})">Remove</button>
      </td>
    `;
    cartItemsContainer.appendChild(row);
  });

  cartCount.innerText = cart.reduce((sum, item) => sum + item.quantity, 0);
  subtotalDisplay.textContent = `KES${subtotal.toFixed(2)}`;
  totalDisplay.textContent = `KES${subtotal.toFixed(2)}`;
  localStorage.setItem("cart", JSON.stringify(cart));
}

function addToCart(name, price) {
  const existing = cart.find(item => item.name === name);
  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ name, price, quantity: 1 });
  }
  updateCart();
}

function changeQuantity(index, delta) {
  cart[index].quantity += delta;
  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }
  updateCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  updateCart();
}

function clearCart() {
  cart = [];
  updateCart();
}

document.querySelectorAll(".add-to-cart").forEach(button => {
  button.addEventListener("click", () => {
    const name = button.dataset.name;
    const price = parseFloat(button.dataset.price);
    addToCart(name, price);
  });
});

document.getElementById("clear-cart-btn").addEventListener("click", clearCart);

// Initial load
updateCart();

</script>
</body>
</html>