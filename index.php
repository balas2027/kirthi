<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Trail - Urban Safety Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #121212 0%, #0a0a0a 100%);
            color: #ffffff;
            overflow-x: hidden;
        }
        #globe-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            transition: all 0.4s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(34, 197, 94, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        #chatbot-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 64px;
            height: 64px;
            background-color: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 100;
        }
        #chatbot-toggle.expanded {
            transform: scale(20);
            opacity: 0;
        }
        #chatbot {
            position: fixed;
            bottom: 24px;
            right: 24px;
            transition: all 0.3s ease;
            z-index: 50;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-black">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-black/40 backdrop-blur-lg border-b border-gray-800/30">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="/api/placeholder/40/40" alt="Haven Trail Logo" class="h-10 w-10 rounded-full">
                <span class="text-xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">Haven Trail</span>
            </div>
            <div class="flex items-center space-x-8">
                <a href="#about" class="text-gray-300 hover:text-green-400 transition font-medium">About Us</a>
                <a href="#maps" class="text-gray-300 hover:text-green-400 transition font-medium">Maps</a>
                <a href="#contact" class="text-gray-300 hover:text-green-400 transition font-medium">Contact Us</a>
                <a href="#" class="text-gray-300 hover:text-green-400 transition font-medium">
                    <i class="ri-discord-line text-xl"></i>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="register.php" class="text-gray-300 hover:text-green-400 transition font-medium">Sign Up</a>
                    <a href="Login.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full transition text-sm font-semibold">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative container mx-auto px-6 pt-32 pb-20 text-center min-h-screen flex items-center justify-center">
        <div id="globe-container"></div>
        <div class="relative z-10 max-w-4xl glass-card p-12 rounded-3xl">
            <h1 class="text-5xl font-bold mb-6 leading-tight">
                Navigate Cities <span class="bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">Safely</span>
            </h1>
            <p class="text-xl mb-10 text-gray-300 leading-relaxed opacity-80">
                Real-time urban safety insights, intelligent route recommendations, and instant alerts to protect you in the city.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-full transition shadow-lg shadow-green-500/30 hover:shadow-green-500/50">
                    Explore Safely
                </a>
                <a href="#" class="border border-green-500 text-green-400 hover:bg-green-500/10 font-semibold py-3 px-8 rounded-full transition">
                    Learn More
                </a>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section id="features" class="container mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold text-center mb-12 text-green-400">Core Features</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553-2.276A1 1 0 0021 13.382V6.618a1 1 0 00-1.447-.894L15 8m0 9V8m0 0l-6-3"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Crime Hotspot Visualization</h3>
                <p class="text-gray-300">Interactive heatmaps revealing urban safety patterns in real-time</p>
            </div>
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Safe Route Recommendation</h3>
                <p class="text-gray-300">AI-powered routing to avoid high-risk areas automatically</p>
            </div>
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Real-Time Alerts</h3>
                <p class="text-gray-300">Instant notifications for potential safety concerns</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="container mx-auto px-6 py-20 bg-gray-900/20">
        <h2 class="text-3xl font-bold text-center mb-16 text-green-400">Our Impact</h2>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="glass-card p-8 rounded-2xl text-center">
                <p class="text-4xl font-bold text-green-400 mb-4">500K+</p>
                <p class="text-gray-300">Safe Routes Generated</p>
            </div>
            <div class="glass-card p-8 rounded-2xl text-center">
                <p class="text-4xl font-bold text-green-400 mb-4">1.2M</p>
                <p class="text-gray-300">Users Protected</p>
            </div>
            <div class="glass-card p-8 rounded-2xl text-center">
                <p class="text-4xl font-bold text-green-400 mb-4">95%</p>
                <p class="text-gray-300">Safety Accuracy</p>
            </div>
            <div class="glass-card p-8 rounded-2xl text-center">
                <p class="text-4xl font-bold text-green-400 mb-4">200+</p>
                <p class="text-gray-300">Cities Covered</p>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="container mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold text-center mb-12 text-green-400">Community Safety Network</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="ri-group-line text-4xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Community Reporting</h3>
                <p class="text-gray-300">Real-time safety updates from local users and trusted sources</p>
            </div>
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="ri-shield-check-line text-4xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Verified Incidents</h3>
                <p class="text-gray-300">Machine learning validates and filters community reports</p>
            </div>
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="ri-message-3-line text-4xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Anonymous Sharing</h3>
                <p class="text-gray-300">Secure and private incident reporting platform</p>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section id="technology" class="container mx-auto px-6 py-20 bg-gray-900/20">
        <h2 class="text-3xl font-bold text-center mb-12 text-green-400">Advanced Safety Technologies</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="ri-brain-line text-4xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">AI-Powered Analysis</h3>
                <p class="text-gray-300">Machine learning algorithms predict and prevent potential safety risks</p>
            </div>
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="ri-database-2-line text-4xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Real-Time Data Processing</h3>
                <p class="text-gray-300">Advanced data analytics for instant safety insights</p>
            </div>
            <div class="glass-card p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-green-500/10 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="ri-lock-line text-4xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-green-400">Privacy-First Design</h3>
                <p class="text-gray-300">End-to-end encryption and anonymous data handling</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="container mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold text-center mb-12 text-green-400">What Users Say</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card p-8 rounded-xl relative">
                <p class="mb-6 text-gray-300 italic">"Haven Trail has completely transformed how I navigate the city. I feel safer and more informed every day."</p>
                <div class="flex items-center">
                    <img src="/api/placeholder/48/48" alt="User Avatar" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold text-green-400">Sarah Thompson</h4>
                        <p class="text-gray-400 text-sm">Urban Professional</p>
                    </div>
                </div>
            </div>
            <div class="glass-card p-8 rounded-xl relative">
                <p class="mb-6 text-gray-300 italic">"As a student who commutes late at night, Haven Trail gives me peace of mind I never had before."</p>
                <div class="flex items-center">
                    <img src="/api/placeholder/48/48" alt="User Avatar" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold text-green-400">Michael Rodriguez</h4>
                        <p class="text-gray-400 text-sm">Student</p>
                    </div>
                </div>
            </div>
            <div class="glass-card p-8 rounded-xl relative">
                <p class="mb-6 text-gray-300 italic">"The data visualization and route recommendations are incredibly precise and helpful."</p>
                <div class="flex items-center">
                    <img src="/api/placeholder/48/48" alt="User Avatar" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold text-green-400">Emily Chen</h4>
                        <p class="text-gray-400 text-sm">City Planner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container mx-auto px-6 py-20 bg-gray-900/20">
        <h2 class="text-3xl font-bold text-center mb-12 text-green-400">Get in Touch</h2>
        <div class="glass-card p-10 rounded-xl max-w-2xl mx-auto">
            <form>
                <input type="text" placeholder="Name" class="w-full p-4 mb-4 bg-gray-800 rounded-lg text-white focus:outline-none focus:border-green-500">
                <input type="email" placeholder="Email" class="w-full p-4 mb-4 bg-gray-800 rounded-lg text-white focus:outline-none focus:border-green-500">
                <textarea placeholder="Message" rows="4" class="w-full p-4 mb-6 bg-gray-800 rounded-lg text-white focus:outline-none focus:border-green-500"></textarea>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black/50 py-12 border-t border-gray-800">
        <div class="container mx-auto text-center">
            <p class="text-gray-400">© 2025 Haven Trail. All rights reserved.</p>
        </div>
    </footer>

    <!-- Chatbot Toggle -->
    <div id="chatbot-toggle" class="text-white">
        <i class="ri-message-3-line text-2xl"></i>
    </div>

    <!-- Chatbot Interface -->
    <div id="chatbot" class="w-80 glass-card rounded-xl shadow-lg hidden">
        <div class="p-4 bg-green-600 rounded-t-xl flex justify-between items-center">
            <h3 class="text-white font-semibold">Legal Assistance</h3>
            <button id="chatbot-close" class="text-white hover:bg-green-700 rounded-full w-8 h-8 flex items-center justify-center">×</button>
        </div>
        <div class="p-4 h-64 overflow-y-auto scrollbar-hide">
            <div class="mb-4 text-gray-300">
                <p>How can I help you today?</p>
            </div>
            <!-- Chatbot messages will be dynamically added here -->
        </div>
        <div class="p-4 border-t border-gray-700">
            <input type="text" placeholder="Ask a legal question..." class="w-full p-2 bg-gray-800 rounded-lg">
        </div>
    </div>

    <script>
        // 3D Globe Animation
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('globe-container').appendChild(renderer.domElement);

        const geometry = new THREE.SphereGeometry(5, 32, 32);
        const material = new THREE.MeshBasicMaterial({ 
            color: 0x22c55e,
            wireframe: true,
            transparent: true,
            opacity: 0.2
        });
        const globe = new THREE.Mesh(geometry, material);
        scene.add(globe);

        camera.position.z = 10;

        function animate() {
            requestAnimationFrame(animate);
            globe.rotation.y += 0.001;
            renderer.render(scene, camera);
        }
        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Chatbot Interaction
        document.addEventListener('DOMContentLoaded', () => {
            const chatbotToggle = document.getElementById('chatbot-toggle');
            const chatbot = document.getElementById('chatbot');
            const chatbotCloseBtn = document.getElementById('chatbot-close');

            chatbotToggle.addEventListener('click', () => {
                chatbotToggle.classList.add('expanded');
                setTimeout(() => {
                    chatbot.classList.remove('hidden');
                    chatbotToggle.classList.add('hidden');
                }, 300);
            });

            chatbotCloseBtn.addEventListener('click', () => {
                chatbot.classList.add('hidden');
                chatbotToggle.classList.remove('expanded', 'hidden');
            });
        });
    </script>
</body>
</html>