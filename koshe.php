<?php
session_start();
include("config/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="George Ngugi's personal portfolio – Web Developer & Graphic Designer.">
  <title>George Ngugi | Web Developer & Graphic Designer</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js"></script>


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: #0f172a;
            color: hsl(51, 80%, 48%);
        }
        
        .gradient-text {
            background: linear-gradient(to right, hsl(29, 96%, 50%), hwb(184 4% 12%));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .gradient-border {
            position: relative;
            border-radius: 0.5rem;
            background: linear-gradient(to right, hsl(184, 100%, 48%), lab(85.94% -21.04 83.91));
            padding: 3px;
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 0.5rem;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-mask: 
                linear-gradient(#ffffff 0 0) content-box, 
                linear-gradient(hsl(71, 90%, 45%) 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        .card {
            transform-style: preserve-3d;
            transition: all 0.5s ease;
        }
        
        .card:hover {
            transform: rotateY(10deg) rotateX(10deg);
        }
        
        .card-content {
            transform: translateZ(20px);
        }
        
        .section-divider {
            height: 150px;
            overflow: hidden;
            position: relative;
        }
        
        .section-divider svg {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
            opacity: 0.6;
        }
        
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .scroll-indicator {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-30px); }
            60% { transform: translateY(-15px); }
        }
        
        .project-card {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }
        
        .project-card:hover {
            transform: translateY(-10px);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="relative">
    <!-- 3D Background -->
    <div class="canvas-container" id="background-canvas"></div>
    
    <!-- Header -->
  <header class="bg-black/80 relative z-30">
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- Navigation bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <span class="text-4xl font-black uppercase tracking-wider gradient-text">GN.MAINA</span>
                <div class="hidden md:flex space-x-8 ml-12">
                    <a href="#Home" class="text-slate-300 hover:text-emerald-400 font-semibold">Home</a>
                    <a href="#project" class="text-slate-300 hover:text-emerald-400 font-semibold">Projects</a>
                    <a href="#about" class="text-slate-300 hover:text-emerald-400 font-semibold">About</a>
                    <a href="#contact" class="text-slate-300 hover:text-emerald-400 font-semibold">Contact</a>
                </div>
            </div>
            <div class="hidden md:block">
                <a href="#contact.php" class="px-6 py-3 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 font-semibold">Get Started</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

    
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center relative overflow-hidden py-20">
        
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between relative z-10">
            <div class="md:w-1/2 mb-12 md:mb-0">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in">
                    Hi, I'm <span class="gradient-text animate-pulse">George Ngugi</span>
                </h1>
                <h2 class="text-2xl md:text-3xl text-gray-300 mb-6 animate-slide-in">
                    Web Developer & <br>Graphic Designer
                </h2>
                <p class="text-blue-400 mb-8 max-w-lg animate-fade-in-delay">
                    I create stunning digital experiences with a perfect blend of creativity and technical expertise. Let's bring your ideas to life!
                </p>
                <div class="flex space-x-4 animate-bounce-in">
                    <a href="#projects" class="px-6 py-3 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 transition-all transform hover:scale-105">View Work</a>
                    <a href="#contact" class="px-6 py-3 rounded-full border border-gray-700 text-gray-300 font-semibold hover:bg-gray-800 transition-all transform hover:scale-105">Contact Me</a>
                </div>
            </div>
            <div class="md:w-1/2 relative perspective-800">
                <div class="card w-full h-96 relative animate-float hover:animate-float-intense transition-all duration-300">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-2/5 mb-12 md:mb-0">
                    <div class="gradient-border h-full">
                        <div class="glass-effect h-full p-1">
                            <img src="imgs/we.jpg" alt="George Ngugi" class="w-full h-full object-cover rounded-lg">
                        </div>
                    </div>
                </div>
                                <div class="space-y-4">
                                    <h3 class="text-xl font-bold animate-glow">George Ngugi</h3>
                                    <div class="flex justify-center space-x-4">
                                        <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-125 hover:rotate-6">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-125 hover:rotate-6">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-125 hover:rotate-6">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-center">
            <div class="text-sm text-gray-500 mb-2">Scroll Down</div>
            <div class="scroll-indicator animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </section>

<style>
/* Define custom animations */
@keyframes float {
    0% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-10px) rotate(1deg); }
    50% { transform: translateY(0px) rotate(0deg); }
    75% { transform: translateY(10px) rotate(-1deg); }
    100% { transform: translateY(0px) rotate(0deg); }
}

@keyframes float-intense {
    0% { transform: translateY(0px) rotate(0deg) scale(1); }
    25% { transform: translateY(-15px) rotate(2deg) scale(1.02); }
    50% { transform: translateY(0px) rotate(0deg) scale(1); }
    75% { transform: translateY(15px) rotate(-2deg) scale(1.02); }
    100% { transform: translateY(0px) rotate(0deg) scale(1); }
}

@keyframes glow {
    0% { text-shadow: 0 0 5px rgba(79, 209, 197, 0.3); }
    50% { text-shadow: 0 0 20px rgba(79, 209, 197, 0.8), 0 0 30px rgba(79, 209, 197, 0.5); }
    100% { text-shadow: 0 0 5px rgba(79, 209, 197, 0.3); }
}

@keyframes fade-in {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes slide-in {
    0% { opacity: 0; transform: translateX(-20px); }
    100% { opacity: 1; transform: translateX(0); }
}

@keyframes bounce-in {
    0% { opacity: 0; transform: scale(0.8); }
    50% { opacity: 1; transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes rotate-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Apply animations to classes */
.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-intense {
    animation: float-intense 4s ease-in-out infinite;
}

.animate-glow {
    animation: glow 2s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 1s ease-out forwards;
}

.animate-fade-in-delay {
    animation: fade-in 1s ease-out 0.3s forwards;
    opacity: 0;
}

.animate-slide-in {
    animation: slide-in 1s ease-out forwards;
}

.animate-bounce-in {
    animation: bounce-in 1s ease-out forwards;
}

.animate-pulse-slow {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-rotate-slow {
    animation: rotate-slow 10s linear infinite;
}
</style>

<style>
/* Define custom animations */
@keyframes float {
    0% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-10px) rotate(1deg); }
    50% { transform: translateY(0px) rotate(0deg); }
    75% { transform: translateY(10px) rotate(-1deg); }
    100% { transform: translateY(0px) rotate(0deg); }
}

@keyframes float-intense {
    0% { transform: translateY(0px) rotate(0deg) scale(1); }
    25% { transform: translateY(-15px) rotate(2deg) scale(1.02); }
    50% { transform: translateY(0px) rotate(0deg) scale(1); }
    75% { transform: translateY(15px) rotate(-2deg) scale(1.02); }
    100% { transform: translateY(0px) rotate(0deg) scale(1); }
}

@keyframes glow {
    0% { text-shadow: 0 0 5px rgba(79, 209, 197, 0.3); }
    50% { text-shadow: 0 0 20px rgba(79, 209, 197, 0.8), 0 0 30px rgba(79, 209, 197, 0.5); }
    100% { text-shadow: 0 0 5px rgba(79, 209, 197, 0.3); }
}

@keyframes fade-in {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes slide-in {
    0% { opacity: 0; transform: translateX(-20px); }
    100% { opacity: 1; transform: translateX(0); }
}

@keyframes bounce-in {
    0% { opacity: 0; transform: scale(0.8); }
    50% { opacity: 1; transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes rotate-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Apply animations to classes */
.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-intense {
    animation: float-intense 4s ease-in-out infinite;
}

.animate-glow {
    animation: glow 2s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 1s ease-out forwards;
}

.animate-fade-in-delay {
    animation: fade-in 1s ease-out 0.3s forwards;
    opacity: 0;
}

.animate-slide-in {
    animation: slide-in 1s ease-out forwards;
}

.animate-bounce-in {
    animation: bounce-in 1s ease-out forwards;
}

.animate-pulse-slow {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-rotate-slow {
    animation: rotate-slow 10s linear infinite;
}
</style>
    
    <!-- About Section -->
    <section id="about" class="py-20 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">About <span class="gradient-text">Me</span></h2>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto"></div>
            </div>
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-2/5 mb-12 md:mb-0">
                    <div class="gradient-border h-full">
                        <div class="glass-effect h-full p-1">
                            <img src="imgs/2.jpeg" alt="George Ngugi" class="w-full h-full object-cover rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-bold mb-4">Web Developer & Graphic Designer</h3>
                    <p class="text-gray-400 mb-6">
                        I'm a passionate web developer and graphic designer with over 5 years of experience creating beautiful, functional digital experiences. My approach combines technical expertise with a keen eye for design, resulting in projects that not only look stunning but also perform exceptionally well.
                    </p>
                    <p class="text-gray-400 mb-6">
                        My journey began with a deep curiosity for both code and design, which led me to develop skills in both areas. This unique combination allows me to bridge the gap between visual aesthetics and technical implementation, creating seamless, cohesive projects.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mb-8 text-blue-300">
                        <div class="flex items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Web Development</span>
                        </div>
                        <div class="flex items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Graphic Design</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>UI/UX Design</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Responsive Design</span>
                        </div>
                    </div>
                    <a href="#contact" class="px-6 py-3 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 transition-all">Let's Connect</a>
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- Skills Section -->
    <section id="skills" class="py-20 bg-gray-900 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">My <span class="gradient-text">Skills</span></h2>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="gradient-border">
                    <div class="glass-effect p-8 rounded-lg h-full">
                        <h3 class="text-2xl font-bold mb-6 gradient-text">Web Development</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>HTML5 & CSS3</span>
                                    <span>95%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 95%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>JavaScript & Frameworks</span>
                                    <span>90%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>React & Vue.js</span>
                                    <span>88%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 ">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>Node.js & Express</span>
                                    <span>85%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-blue-700">
                                    <span>Tailwind CSS & SASS</span>
                                    <span>92%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gradient-border">
                    <div class="glass-effect p-8 rounded-lg h-full">
                        <h3 class="text-2xl font-bold mb-6 gradient-text">Graphic Design</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>Adobe Photoshop</span>
                                    <span>90%</span>
                                </div>
                                <div class="w-full bg--700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>Canva design</span>
                                    <span>88%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>UI/UX Design</span>
                                    <span>85%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>Figma & Sketch</span>
                                    <span>92%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2 text-red-400">
                                    <span>3D Modeling & Animation</span>
                                    <span>40%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full" style="width: 40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="glass-effect p-6 rounded-lg text-center transform transition-all hover:scale-105">
                    <div class="text-4xl font-bold gradient-text mb-2">2+</div>
                    <div class="text-gray-400">Years Experience</div>
                </div>
                <div class="glass-effect p-6 rounded-lg text-center transform transition-all hover:scale-105">
                    <div class="text-4xl font-bold gradient-text mb-2">10+</div>
                    <div class="text-gray-400">Projects Completed</div>
                </div>
                <div class="glass-effect p-6 rounded-lg text-center transform transition-all hover:scale-105">
                    <div class="text-4xl font-bold gradient-text mb-2">10+</div>
                    <div class="text-gray-400">Happy Clients</div>
                </div>
                <div class="glass-effect p-6 rounded-lg text-center transform transition-all hover:scale-105">
                    <div class="text-4xl font-bold gradient-text mb-2">0+</div>
                    <div class="text-gray-400">Awards Won</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Projects Section -->
    <section id="projects" class="py-20 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Featured <span class="gradient-text">Projects</span></h2>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto"></div>
            </div>
            <div class="flex justify-center mb-10">
                <div class="flex space-x-2 md:space-x-4">
                    <button class="px-4 py-2 rounded-full bg-blue-500 text-white">All</button>
                    <button class="px-4 py-2 rounded-full bg-gray-800 text-gray-300 hover:bg-gray-700">Web Design</button>
                    <button class="px-4 py-2 rounded-full bg-gray-800 text-gray-300 hover:bg-gray-700">Graphic Design</button>
                    <button class="px-4 py-2 rounded-full bg-gray-800 text-gray-300 hover:bg-gray-700">3D Design</button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Project 1 -->
                <div class="project-card">
                    <div class="gradient-border">
                        <div class="glass-effect rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="22.png" alt="E-commerce Website" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h3 class="text-xl font-bold mb-2">E-commerce Website</h3>
                                    <p class="text-sm text-gray-300">Web Development</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-400 mb-4">A fully responsive e-commerce platform with seamless user experience and modern payment integration.</p>
                                <div class="flex space-x-2">
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">React</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Node.js</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">MongoDB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Project 2 -->
                <div class="project-card">
                    <div class="gradient-border">
                        <div class="glass-effect rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="3.jpeg" alt="Brand Identity Design" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h3 class="text-xl font-bold mb-2">Brand Identity Design</h3>
                                    <p class="text-sm text-gray-300">Graphic Design</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-400 mb-4">Complete brand identity package including logo, business cards, and social media assets.</p>
                                <div class="flex space-x-2">
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Illustrator</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Photoshop</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Branding</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Project 3 -->
                <div class="project-card">
                    <div class="gradient-border">
                        <div class="glass-effect rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="Happiness.jpeg" alt="3D Product Visualization" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h3 class="text-xl font-bold mb-2">3D Product Visualization</h3>
                                    <p class="text-sm text-gray-300">3D Design</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-400 mb-4">Photorealistic 3D product renderings for marketing and promotional materials.</p>
                                <div class="flex space-x-2">
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Blender</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Cinema 4D</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">3D Modeling</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Project 4 -->
                <div class="project-card">
                    <div class="gradient-border">
                        <div class="glass-effect rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="2.jpeg" alt="Dashboard UI" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h3 class="text-xl font-bold mb-2">Dashboard UI Design</h3>
                                    <p class="text-sm text-gray-300">UI/UX Design</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-400 mb-4">Modern and intuitive dashboard interface for data analytics platform.</p>
                                <div class="flex space-x-2">
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Figma</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">UI Design</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">UX Research</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Project 5 -->
                <div class="project-card">
                    <div class="gradient-border">
                        <div class="glass-effect rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="111.png" alt="Mobile App" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h3 class="text-xl font-bold mb-2">Kading wash website</h3>
                                    <p class="text-sm text-gray-300"> web development using tailwindcss </p>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-400 mb-4">Cross-platform fitness tracking mobile application with social features.</p>
                                <div class="flex space-x-2">
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">React Native</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Firebase</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">UX Design</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Project 6 -->
                <div class="project-card">
                    <div class="gradient-border">
                        <div class="glass-effect rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="imgs/4.jpg" alt="Website Redesign" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h3 class="text-xl font-bold mb-2">Corporate Website Redesign</h3>
                                    <p class="text-sm text-gray-300">Web Development</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-400 mb-4">Complete overhaul and modernization of corporate website with focus on conversion.</p>
                                <div class="flex space-x-2">
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Vue.js</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">Tailwind CSS</span>
                                    <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">SEO</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="#" class="px-6 py-3 rounded-full border border-gray-700 text-gray-300 font-semibold hover:bg-gray-800 transition-all">View All Projects</a>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-900 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Client <span class="gradient-text">Testimonials</span></h2>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="glass-effect p-8 rounded-lg transform transition-all hover:translate-y-[-10px]">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                <img src="imgs/c.jpg" alt="Client" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold">Sarah w</h4>
                                <p class="text-sm text-gray-400">CEO, Tech</p>
                            </div>
                        </div>
                        <div class="text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400">"George delivered an exceptional website that perfectly captures our brand. His ability to combine stunning visuals with flawless functionality exceeded our expectations. The project was delivered on time and has significantly improved our online presence."</p>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="glass-effect p-8 rounded-lg transform transition-all hover:translate-y-[-10px]">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                <img src="imgs/we.jpg" alt="Client" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold">Michael Njuguna</h4>
                                <p class="text-sm text-gray-400">Marketing Director, Fusion</p>
                            </div>
                        </div>
                        <div class="text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400">"Working with George on our brand redesign was a fantastic experience. His creative vision and technical skills are truly impressive. He took the time to understand our goals and delivered a cohesive brand identity that has been instrumental in our growth."</p>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="glass-effect p-8 rounded-lg transform transition-all hover:translate-y-[-10px]">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                <img src="imgs/2.jpeg" alt="Client" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold">Lisa Nguyen</h4>
                                <p class="text-sm text-gray-400">Founder, Bloom Studio</p>
                            </div>
                        </div>
                        <div class="text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                           
                <!-- Testimonial 2 -->
                <div class="glass-effect p-8 rounded-lg transform transition-all hover:translate-y-[-10px]">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                <img src="imgs/2.png" alt="Client" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold">Michael Njoroge</h4>
                                <p class="text-sm text-gray-400">Marketing Director, Fusion Media</p>
                            </div>
                        </div>
                        <div class="text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400">"George's graphic design work transformed our brand identity. His attention to detail and creative problem-solving resulted in visuals that truly capture our company's essence. The designs have been instrumental in our latest marketing campaign's success."</p>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="glass-effect p-8 rounded-lg transform transition-all hover:translate-y-[-10px]">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                                <img src="imgs/2.jpeg" alt="Client" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold">Jessica Williams</h4>
                                <p class="text-sm text-gray-400">Founder, Artisan Studios</p>
                            </div>
                        </div>
                        <div class="text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400">"Working with George on our interactive portfolio was a game-changer. His ability to blend engaging UI/UX with cutting-edge development resulted in a platform that has received numerous industry accolades. George isn't just a developer; he's a strategic creative partner."</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="py-20 relative">
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
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Get In <span class="gradient-text">Touch</span></h2>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto"></div>
                <p class="mt-4 text-gray-400 max-w-xl mx-auto">Have a project in mind or want to discuss potential collaborations? Fill out the form below, and I'll get back to you as soon as possible.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="gradient-border">
                    <div class="glass-effect p-8 rounded-lg h-full">
                        <form action="message.php" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Your Name</label>
                                    <input type="text" id="name" name="name" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/20 rounded-lg">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Your Email</label>
                                    <input type="email" id="email" name="email" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/20 rounded-lg">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="subject" class="block text-sm font-medium text-gray-400 mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/20 rounded-lg">
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-gray-400 mb-2">Your Message</label>
                                <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-500/20 rounded-lg"></textarea>
                            </div>
                            <button type="submit" class="w-full px-6 py-3 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 transition-all">Send Message</button>
                        </form>
                    </div>
                </div>
                <div>
                    <div class="gradient-border mb-8">
                        <div class="glass-effect p-8 rounded-lg">
                            <h3 class="text-xl font-bold mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400">Email</p>
                                        <p>contact@georgengugi.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400">Phone</p>
                                        <p>+254-700110527</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400">Location</p>
                                        <p>Nairobi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gradient-border">
                        <div class="glass-effect p-8 rounded-lg">
                            <h3 class="text-xl font-bold mb-4">Follow Me</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-800 hover:bg-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-800 hover:bg-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-800 hover:bg-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-800 hover:bg-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4"/>
                                    </svg>
                                </a>
                            
    </section>
    <!-- Footer -->
    <footer class="bg-gray-900 py-8">
        <div class="container mx-auto text-center">
            <p class="text-gray-400">© 2023 George Ngugi. All rights reserved.</p>
        </div>
         <!-- Mobile menu -->
    <div id="mobile-menu" class="fixed inset-0 z-50 bg-gray-400 hidden">
        <div class="flex justify-end p-6">
            <button id="close-mobile-menu" class="text-white focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center justify-center h-full">
            <a href="#home" class="text-3xl font-semibold text-red-400 mb-8 hover:text-emerald-400">Home</a>
            <a href="#project" class="text-3xl font-semibold text-red-400 mb-8 hover:text-emerald-400">Projects</a>
            <a href="#about" class="text-3xl font-semibold text-red-400 mb-8 hover:text-emerald-400">About</a>
            <a href="#contact" class="text-3xl font-semibold text-red-400 mb-8 hover:text-emerald-400">Contact</a>
            <a href="#contact" class="mt-4 px-8 py-3 bg-red-600 text-white rounded-full hover:bg-emerald-700 transition-colors font-semibold">Get Started</a>
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
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fadeIn {
                    animation: fadeIn 0.8s ease forwards;
                }
                section {
                    opacity: 0;
                }
            </style>
        `);
    </script>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js"></script>

    
    <script>
        // Wait for the DOM to be fully loaded before executing
document.addEventListener('DOMContentLoaded', () => {
    // Handle smooth scrolling for all internal links
    setupSmoothScrolling();
    
    // Initialize the 3D card hover effect
    initializeCardEffect();
    
    // Set up scroll animations
    setupScrollAnimations();
});

/**
 * Sets up smooth scrolling for all internal links
 */
function setupSmoothScrolling() {
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    
    internalLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Smooth scroll to the target element
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Initialize the 3D card hover effect for the profile card
 */
function initializeCardEffect() {
    const card = document.querySelector('.card');
    
    if (!card) return;
    
    // Set initial transform for the floating animation
    setInitialCardTransform(card);
    
    // Add mouse move event listener for 3D effect
    card.addEventListener('mousemove', (e) => {
        handleCardMouseMove(e, card);
    });
    
    // Reset transform when mouse leaves
    card.addEventListener('mouseleave', () => {
        resetCardTransform(card);
    });
}

/**
 * Set initial transform state for the card
 * @param {HTMLElement} card - The card element
 */
function setInitialCardTransform(card) {
    // Apply initial floating animation
    const randomRotateX = (Math.random() - 0.5) * 5;
    const randomRotateY = (Math.random() - 0.5) * 5;
    
    card.style.transform = `rotateX(${randomRotateX}deg) rotateY(${randomRotateY}deg)`;
}

/**
 * Handle mouse movement over the card for 3D effect
 * @param {Event} e - The mouse event
 * @param {HTMLElement} card - The card element
 */
function handleCardMouseMove(e, card) {
    const cardRect = card.getBoundingClientRect();
    const cardCenterX = cardRect.left + cardRect.width / 2;
    const cardCenterY = cardRect.top + cardRect.height / 2;
    
    // Calculate mouse position relative to card center
    const mouseX = e.clientX - cardCenterX;
    const mouseY = e.clientY - cardCenterY;
    
    // Calculate rotation values (the farther from center, the more rotation)
    const rotateY = mouseX * 0.05;
    const rotateX = -mouseY * 0.05;
    
    // Apply the rotation transform
    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    
    // Add subtle shadow effect based on rotation
    updateCardShadow(card, rotateX, rotateY);
}

/**
 * Update card shadow based on rotation angles
 * @param {HTMLElement} card - The card element
 * @param {number} rotateX - X rotation angle
 * @param {number} rotateY - Y rotation angle
 */
function updateCardShadow(card, rotateX, rotateY) {
    const shadowX = rotateY * 0.5;
    const shadowY = rotateX * 0.5;
    const shadowBlur = Math.max(Math.abs(rotateX), Math.abs(rotateY)) + 5;
    
    card.style.boxShadow = `${shadowX}px ${shadowY}px ${shadowBlur}px rgba(0, 0, 0, 0.3), 
                          0 0 30px rgba(72, 100, 255, 0.15)`;
}

/**
 * Reset the card transform to default state
 * @param {HTMLElement} card - The card element
 */
function resetCardTransform(card) {
    // Return to gentle floating animation
    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
    card.style.boxShadow = '0 0 30px rgba(72, 100, 255, 0.15)';
    
    // Re-trigger the floating animation
    setTimeout(() => setInitialCardTransform(card), 100);
}

/**
 * Setup animations that trigger on scroll
 */
function setupScrollAnimations() {
    // Add the scroll event listener
    window.addEventListener('scroll', () => {
        fadeInElementsOnScroll();
    });
    
    // Trigger once on page load
    fadeInElementsOnScroll();
}

/**
 * Fade in elements as they enter the viewport
 */
function fadeInElementsOnScroll() {
    // Select all elements that should animate on scroll
    const animateElements = document.querySelectorAll('.project, .skill-card, .contact-form');
    
    animateElements.forEach(element => {
        const elementPosition = element.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        
        // If element is in viewport
        if (elementPosition.top < windowHeight * 0.85) {
            element.classList.add('fade-in');
        }
    });
}

/**
 * Enable dark mode toggle functionality
 */
function setupDarkModeToggle() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    
    if (darkModeToggle) {
        // Check for saved user preference
        const darkModeSaved = localStorage.getItem('darkMode') === 'true';
        
        // Apply saved preference
        if (darkModeSaved) {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }
        
        // Handle toggle changes
        darkModeToggle.addEventListener('change', () => {
            if (darkModeToggle.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'false');
            }
        });
    }
}

// Call setup for dark mode toggle
setupDarkModeToggle();

// Add loading animation for page
window.addEventListener('load', () => {
    const loader = document.querySelector('.loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }, 500);
    }
});
        // GSAP Animation
  
        document.addEventListener('DOMContentLoaded', () => {
  // Tilt.js initialization
  $('.card').tilt({
    maxTilt: 15,
    speed: 400,
    glare: true,
    maxGlare: 0.3
  });

  // GSAP intro animation
  gsap.from('header', { opacity: 0, y: -50, duration: 1, ease: 'power3.out' });
  gsap.from('.card', { opacity: 0, y: 100, duration: 1.2, ease: 'power2.out', delay: 0.5 });
  gsap.from('.nav-link', {
    opacity: 0,
    y: -10,
    duration: 0.6,
    stagger: 0.2,
    ease: 'back.out(1.7)'
  });

  // Smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // Background animation using Three.js
  initThreeBackground();
});

function initThreeBackground() {
  const canvasContainer = document.getElementById('background-canvas');
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(75, canvasContainer.offsetWidth / canvasContainer.offsetHeight, 0.1, 1000);
  const renderer = new THREE.WebGLRenderer({ alpha: true });
  renderer.setSize(canvasContainer.offsetWidth, canvasContainer.offsetHeight);
  canvasContainer.appendChild(renderer.domElement);

  // Particle system
  const geometry = new THREE.BufferGeometry();
  const particles = 5000;
  const positions = [];

  for (let i = 0; i < particles; i++) {
    positions.push((Math.random() - 0.5) * 1000);
    positions.push((Math.random() - 0.5) * 1000);
    positions.push((Math.random() - 0.5) * 1000);
  }

  geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
  const material = new THREE.PointsMaterial({ color: 0x66ccff, size: 1 });
  const points = new THREE.Points(geometry, material);
  scene.add(points);

  camera.position.z = 300;

  function animate() {
    requestAnimationFrame(animate);
    points.rotation.y += 0.0005;
    renderer.render(scene, camera);
  }

  animate();
  window.addEventListener('resize', () => {
    camera.aspect = canvasContainer.offsetWidth / canvasContainer.offsetHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(canvasContainer.offsetWidth, canvasContainer.offsetHeight);
  });
}
$(document).ready(function () {
    $('.card').tilt({
      maxTilt: 15,
      speed: 400,
      glare: true,
      maxGlare: 0.5
    });
  });
        </script>
</body>
</html>
