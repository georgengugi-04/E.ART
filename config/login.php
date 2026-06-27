<?php
session_start();

// Configuration
$config = [
    'db_host' => 'localhost',
    'db_name' => 'kenya_care_database', 
    'db_user' => 'root',           // Default XAMPP username
    'db_pass' => ''                // Default XAMPP password (empty)
];
// Database connection
try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
        $config['db_user'],
        $config['db_pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$error_message = '';
$success_message = '';

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);
    
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, email, password, name, role, is_active, last_login FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Update last login
                $update_stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $update_stmt->execute([$user['id']]);
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                
                // Handle remember me
                if ($remember_me) {
                    $token = bin2hex(random_bytes(32));
                    $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));
                    
                    // Store token in database
                    $token_stmt = $pdo->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
                    $token_stmt->execute([$user['id'], hash('sha256', $token), $expiry]);
                    
                    // Set cookie
                    setcookie('remember_token', $token, strtotime('+30 days'), '/', '', true, true);
                }
                
                // Redirect to home or intended page
                $redirect_url = isset($_SESSION['intended_url']) ? $_SESSION['intended_url'] : 'home.php';
                unset($_SESSION['intended_url']);
                header("Location: $redirect_url");
                exit();
            } else {
                $error_message = "Invalid email or password";
            }
        } catch (PDOException $e) {
            $error_message = "Login failed. Please try again.";
            error_log("Login error: " . $e->getMessage());
        }
    }
}

// Handle registration submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['reg_email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['reg_password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($_POST['phone']);
    $member_type = trim($_POST['member_type']);
    $location = trim($_POST['location']);
    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "Please fill in all required fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match";
    } else {
        try {
            // Check if user already exists
            $check_stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check_stmt->execute([$email]);
            
            if ($check_stmt->fetch()) {
                $error_message = "An account with this email already exists";
            } else {
                // Create new user
                $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
                $verification_token = bin2hex(random_bytes(32));
                
                $insert_stmt = $pdo->prepare("
                    INSERT INTO users (name, email, password, phone, member_type, location, verification_token, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                
                $insert_stmt->execute([$name, $email, $hashed_password, $phone, $member_type, $location, $verification_token]);
                
                $success_message = "Account created successfully! Please check your email to verify your account.";
                
                // In a real application, you would send a verification email here
                // mail($email, "Verify your Kenya I Care account", "Click here to verify: " . "verify.php?token=" . $verification_token);
            }
        } catch (PDOException $e) {
            $error_message = "Registration failed. Please try again.";
            error_log("Registration error: " . $e->getMessage());
        }
    }
}

// Check for remember me token
if (!isset($_SESSION['logged_in']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $hashed_token = hash('sha256', $token);
    
    try {
        $stmt = $pdo->prepare("
            SELECT u.id, u.email, u.name, u.role 
            FROM users u 
            JOIN remember_tokens rt ON u.id = rt.user_id 
            WHERE rt.token = ? AND rt.expires_at > NOW() AND u.is_active = 1
        ");
        $stmt->execute([$hashed_token]);
        $user = $stmt->fetch();
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Remember token error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kenya I Care Initiatives</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700&display=swap');
        
        :root {
            --primary-green: #22c55e;
            --primary-deep-green: #16a34a;
            --dark-green: #15803d;
            --light-green: #4ade80;
            --accent-gold: #fbbf24;
            --kenya-red: #dc2626;
            --background-dark: #1a1a1a;
            --text-light: #f8fafc;
        }

        * {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, var(--background-dark) 0%, var(--dark-green) 50%, var(--primary-green) 100%);
            color: var(--text-light);
            min-height: 100vh;
        }

        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .gradient-kenya {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-deep-green) 100%);
        }

        .gradient-text-kenya {
            background: linear-gradient(135deg, var(--light-green), var(--accent-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glassmorphism {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .shape:nth-child(1) {
            top: 20%;
            left: 20%;
            animation-delay: 0s;
            color: var(--primary-green);
        }

        .shape:nth-child(2) {
            top: 60%;
            left: 80%;
            animation-delay: -5s;
            color: var(--primary-deep-green);
        }

        .shape:nth-child(3) {
            top: 80%;
            left: 10%;
            animation-delay: -10s;
            color: var(--accent-gold);
        }

        .shape:nth-child(4) {
            top: 10%;
            left: 70%;
            animation-delay: -15s;
            color: var(--light-green);
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg) scale(1);
            }
            25% { 
                transform: translateY(-20px) rotate(90deg) scale(1.1);
            }
            50% { 
                transform: translateY(-40px) rotate(180deg) scale(0.9);
            }
            75% { 
                transform: translateY(-20px) rotate(270deg) scale(1.1);
            }
        }

        .btn-kenya {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-kenya:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-kenya:hover:before {
            left: 100%;
        }

        .btn-kenya:hover {
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(34, 197, 94, 0.4);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--light-green);
            box-shadow: 0 0 20px rgba(74, 222, 128, 0.3);
            outline: none;
        }

        .login-container {
            position: relative;
            z-index: 10;
        }

        .toggle-form {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-form:hover {
            color: var(--accent-gold);
        }

        .alert {
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .strength-weak { background: #ef4444; }
        .strength-medium { background: #f59e0b; }
        .strength-strong { background: #10b981; }

        .social-login {
            transition: all 0.3s ease;
        }

        .social-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape text-8xl">🇰🇪</div>
        <div class="shape text-6xl">❤️</div>
        <div class="shape text-7xl">🤝</div>
        <div class="shape text-5xl">🌍</div>
    </div>

    <div class="login-container w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center space-x-3 mb-4">
                <div class="w-16 h-16 gradient-kenya rounded-2xl flex items-center justify-center">
                    <span class="text-white font-black text-3xl">K</span>
                </div>
                <div>
                    <span class="text-2xl font-black uppercase tracking-wider gradient-text-kenya block">KENYA</span>
                    <span class="text-xl font-bold uppercase tracking-wider gradient-text-kenya">I CARE</span>
                </div>
            </div>
            <p class="text-slate-300 text-lg">Empowering Communities, Building Kenya</p>
        </div>

        <!-- Alert Messages -->
        <?php if ($error_message): ?>
            <div class="alert bg-red-500/20 border border-red-500/30 text-red-200 px-6 py-4 rounded-2xl mb-6">
                <div class="flex items-center">
                    <span class="text-xl mr-3">⚠️</span>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert bg-green-500/20 border border-green-500/30 text-green-200 px-6 py-4 rounded-2xl mb-6">
                <div class="flex items-center">
                    <span class="text-xl mr-3">✅</span>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login/Register Form Container -->
        <div class="glassmorphism rounded-3xl p-8">
            <!-- Tab Navigation -->
            <div class="flex mb-8">
                <button id="loginTab" class="flex-1 py-3 px-6 text-center font-semibold rounded-xl bg-white/10 text-white border-b-2 border-green-400">
                    Sign In
                </button>
                <button id="registerTab" class="flex-1 py-3 px-6 text-center font-semibold rounded-xl text-slate-400 hover:text-white transition-colors">
                    Sign Up
                </button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" method="POST" action="" class="space-y-6">
                <input type="hidden" name="login" value="1">
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                           class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400"
                           placeholder="Enter your email">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400 pr-12"
                               placeholder="Enter your password">
                        <button type="button" id="togglePassword" class="absolute right-4 top-3 text-slate-400 hover:text-white">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-slate-300">
                        <input type="checkbox" name="remember_me" class="mr-2 rounded">
                        Remember me
                    </label>
                    <a href="forgot-password.php" class="text-sm text-green-400 hover:text-green-300">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn-kenya w-full py-4 rounded-xl text-white font-semibold text-lg">
                    Sign In to Kenya I Care
                </button>
            </form>

            <!-- Registration Form -->
            <form id="registerForm" method="POST" action="" class="space-y-6 hidden">
                <input type="hidden" name="register" value="1">
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" required
                           class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400"
                           placeholder="Enter your full name">
                </div>

                <div>
                    <label for="reg_email" class="block text-sm font-semibold text-slate-300 mb-2">Email Address *</label>
                    <input type="email" id="reg_email" name="reg_email" required
                           class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400"
                           placeholder="Enter your email">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-300 mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone"
                           class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400"
                           placeholder="Enter your phone number (+254...)">
                </div>

                <div>
                    <label for="location" class="block text-sm font-semibold text-slate-300 mb-2">Location/County</label>
                    <select id="location" name="location"
                            class="form-input w-full px-4 py-3 rounded-xl text-white">
                        <option value="">Select your county</option>
                        <option value="nairobi">Nairobi</option>
                        <option value="mombasa">Mombasa</option>
                        <option value="kiambu">Kiambu</option>
                        <option value="nakuru">Nakuru</option>
                        <option value="machakos">Machakos</option>
                        <option value="kisumu">Kisumu</option>
                        <option value="uasin_gishu">Uasin Gishu</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="member_type" class="block text-sm font-semibold text-slate-300 mb-2">How would you like to contribute?</label>
                    <select id="member_type" name="member_type"
                            class="form-input w-full px-4 py-3 rounded-xl text-white">
                        <option value="">Select membership type</option>
                        <option value="volunteer">Volunteer</option>
                        <option value="donor">Donor</option>
                        <option value="community_leader">Community Leader</option>
                        <option value="organization">Organization/NGO</option>
                        <option value="beneficiary">Beneficiary</option>
                        <option value="supporter">General Supporter</option>
                    </select>
                </div>

                <div>
                    <label for="reg_password" class="block text-sm font-semibold text-slate-300 mb-2">Password *</label>
                    <input type="password" id="reg_password" name="reg_password" required
                           class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400"
                           placeholder="Create a password">
                    <div id="passwordStrength" class="password-strength mt-2"></div>
                    <p class="text-xs text-slate-400 mt-1">Minimum 8 characters</p>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-semibold text-slate-300 mb-2">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-slate-400"
                           placeholder="Confirm your password">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="terms" required class="mr-2">
                    <label for="terms" class="text-sm text-slate-300">
                        I agree to the <a href="terms.php" class="text-green-400 hover:text-green-300">Terms of Service</a> 
                        and <a href="privacy.php" class="text-green-400 hover:text-green-300">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="btn-kenya w-full py-4 rounded-xl text-white font-semibold text-lg">
                    Join Kenya I Care Community
                </button>
            </form>

            <!-- Social Login Divider -->
            <div class="my-8 flex items-center">
                <div class="flex-1 h-px bg-slate-600"></div>
                <span class="px-4 text-sm text-slate-400">or continue with</span>
                <div class="flex-1 h-px bg-slate-600"></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <button class="social-login flex items-center justify-center py-3 px-4 bg-white/10 rounded-xl text-white font-semibold">
                    <span class="mr-2">📧</span>
                    Google
                </button>
                <button class="social-login flex items-center justify-center py-3 px-4 bg-white/10 rounded-xl text-white font-semibold">
                    <span class="mr-2">📱</span>
                    Facebook
                </button>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="index.html" class="text-slate-400 hover:text-white transition-colors">
                ← Back to Home
            </a>
        </div>
    </div>

    <script>
        // Tab switching
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginTab.addEventListener('click', () => {
            loginTab.classList.add('bg-white/10', 'text-white', 'border-b-2', 'border-green-400');
            loginTab.classList.remove('text-slate-400');
            registerTab.classList.remove('bg-white/10', 'text-white', 'border-b-2', 'border-green-400');
            registerTab.classList.add('text-slate-400');
            
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });

        registerTab.addEventListener('click', () => {
            registerTab.classList.add('bg-white/10', 'text-white', 'border-b-2', 'border-green-400');
            registerTab.classList.remove('text-slate-400');
            loginTab.classList.remove('bg-white/10', 'text-white', 'border-b-2', 'border-green-400');
            loginTab.classList.add('text-slate-400');
            
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        });

        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        // Password strength indicator
        document.getElementById('reg_password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('passwordStrength');
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            strengthIndicator.className = 'password-strength mt-2';
            if (strength === 0) {
                strengthIndicator.style.width = '0%';
            } else if (strength <= 2) {
                strengthIndicator.classList.add('strength-weak');
                strengthIndicator.style.width = '33%';
            } else if (strength === 3) {
                strengthIndicator.classList.add('strength-medium');
                strengthIndicator.style.width = '66%';
            } else {
                strengthIndicator.classList.add('strength-strong');
                strengthIndicator.style.width = '100%';
            }
        });

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('reg_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>