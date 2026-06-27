<?php
// register.php - User registration page

// Start session
session_start();

// Include database connection
require_once "config/connect.php";

// Create database connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error_message = "";
$name = "";
$email = "";
$phone = "";

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to home page or dashboard
    header("Location: home.php");
    exit;
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate form data
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error_message = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error_message = "Email already exists. Please use a different email or login.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user data into database
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);
            
            if ($stmt->execute()) {
                // Redirect to login page with success message
                header("Location: login.php?registered=success");
                exit;
            } else {
                $error_message = "Registration failed. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Safari Shop</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .safari-gradient {
            background: linear-gradient(135deg, #ff9a00 0%, #ff6a00 100%);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo and Header -->
        <div class="text-center mb-8">
            <div class="safari-gradient inline-block p-3 rounded-full mb-4">
                <i class="fas fa-safari text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Safari Shop</h1>
            <p class="text-gray-600">Create a new account</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Message Display -->
            <?php if ($error_message): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="px-8 pt-6 pb-8">
                <!-- Full Name Field -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="name">
                        Full Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            class="appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="name" 
                            name="name" 
                            type="text" 
                            placeholder="Full name"
                            value="<?php echo htmlspecialchars($name); ?>"
                            required
                        >
                    </div>
                </div>
                
                <!-- Email Field -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            class="appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="email" 
                            name="email" 
                            type="email" 
                            placeholder="your@email.com"
                            value="<?php echo htmlspecialchars($email); ?>"
                            required
                        >
                    </div>
                </div>
                
                <!-- Phone Field -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="phone">
                        Phone Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input 
                            class="appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="phone" 
                            name="phone" 
                            type="text" 
                            placeholder="254XXXXXXXXX"
                            value="<?php echo htmlspecialchars($phone); ?>"
                            required
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Enter your M-Pesa registered phone number starting with 254</p>
                </div>
                
                <!-- Password Field -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            class="appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="password" 
                            name="password" 
                            type="password" 
                            placeholder="******************"
                            required
                            minlength="8"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long</p>
                </div>
                
                <!-- Confirm Password Field -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="confirm_password">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            class="appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="confirm_password" 
                            name="confirm_password" 
                            type="password" 
                            placeholder="******************"
                            required
                            minlength="8"
                        >
                    </div>
                </div>
                
                <!-- Terms and Conditions -->
                <div class="mb-6 flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded"
                            required
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            I agree to the 
                            <a href="terms.php" class="text-orange-500 hover:text-orange-700">Terms and Conditions</a> 
                            and 
                            <a href="privacy.php" class="text-orange-500 hover:text-orange-700">Privacy Policy</a>
                        </label>
                    </div>
                </div>
                
                <!-- Register Button -->
                <div class="mb-6">
                    <button 
                        class="w-full safari-gradient text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline hover:opacity-90 transition-opacity duration-200" 
                        type="submit"
                    >
                        Create Account
                    </button>
                </div>
                
                <!-- Divider -->
                <div class="relative flex items-center justify-center mb-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-gray-600">or register with</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                
                <!-- Social Registration -->
                <div class="flex justify-center space-x-4 mb-6">
                    <!-- Google -->
                    <a href="#" class="flex items-center justify-center w-12 h-12 rounded-full border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        <i class="fab fa-google text-gray-700"></i>
                    </a>
                    <!-- Facebook -->
                    <a href="#" class="flex items-center justify-center w-12 h-12 rounded-full border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        <i class="fab fa-facebook-f text-gray-700"></i>
                    </a>
                    <!-- Apple -->
                    <a href="#" class="flex items-center justify-center w-12 h-12 rounded-full border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        <i class="fab fa-apple text-gray-700"></i>
                    </a>
                </div>
            </form>
            
            <!-- Login Link -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center">
                <p class="text-gray-600 text-sm">
                    Already have an account? 
                    <a href="login.php" class="text-orange-500 hover:text-orange-700 font-semibold">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            &copy; <?php echo date('Y'); ?> Safari Shop. All rights reserved.
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-red-100');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 1s';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 1000);
            });
        }, 5000);
        
        // Password match validation
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords don't match");
            } else {
                confirmPassword.setCustomValidity('');
            }
        }
        
        password.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);
        
        // Phone number formatting
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = this.value.replace(/\s+/g, ''); // Remove spaces
            
            // Format phone number as needed
            if (phone.startsWith('0')) {
                phone = '254' + phone.substring(1);
            } else if (phone.startsWith('+')) {
                phone = phone.substring(1);
            }
            
            this.value = phone;
        });
    });
    </script>
</body>
</html>
