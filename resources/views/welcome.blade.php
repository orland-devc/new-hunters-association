<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #6366F1;
            --primary-dark: #4F46E5;
            --secondary: #EC4899;
            --tertiary: #8B5CF6;
            --bg-dark: #0F172A;
            --bg-light: #F8FAFC;
            --text-light: #F8FAFC;
            --text-dark: #1E293B;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            overflow-x: hidden;
        }
        
        code {
            font-family: 'Fira Code', monospace;
        }
        
        .hero {
            min-height: 85vh;
            position: relative;
            overflow: hidden;
        }
        
        .particles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            animation: float 15s infinite linear;
            opacity: 0.5;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
            }
            25% {
                transform: translateY(-20px) translateX(10px) rotate(90deg);
            }
            50% {
                transform: translateY(0px) translateX(20px) rotate(180deg);
            }
            75% {
                transform: translateY(20px) translateX(10px) rotate(270deg);
            }
            100% {
                transform: translateY(0) translateX(0) rotate(360deg);
            }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--tertiary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 8s infinite linear;
            background-size: 200% auto;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .code-block {
            position: relative;
            background-color: rgba(15, 23, 42, 0.8);
            border-radius: 8px;
            border: 1px solid rgba(99, 102, 241, 0.3);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
            backdrop-filter: blur(8px);
        }
        
        .typewriter {
            overflow: hidden;
            border-right: 2px solid var(--primary);
            white-space: nowrap;
            margin: 0;
            animation: typing 3s steps(30, end), blink-caret 0.5s step-end infinite;
        }
        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: var(--primary) }
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }
        
        .glow {
            filter: drop-shadow(0 0 8px var(--primary));
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
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-800 px-6 py-4 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center">
                    <svg class="h-10 w-10 glow" viewBox="0 0 50 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M49.032 12.96L25.016 0.102L1 12.96V38.676L25.016 51.534L49.032 38.676V12.96Z" fill="#0F172A" stroke="url(#paint0_linear)" stroke-width="2"/>
                        <path d="M25.016 26.037L13.008 19.499V32.137L25.016 38.676L37.024 32.137V19.499L25.016 26.037Z" stroke="url(#paint1_linear)" stroke-width="2"/>
                        <defs>
                            <linearGradient id="paint0_linear" x1="1" y1="25.818" x2="49.032" y2="25.818" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#6366F1"/>
                                <stop offset="1" stop-color="#EC4899"/>
                            </linearGradient>
                            <linearGradient id="paint1_linear" x1="13.008" y1="29.087" x2="37.024" y2="29.087" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#8B5CF6"/>
                                <stop offset="1" stop-color="#EC4899"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="ml-3 text-2xl font-bold gradient-text">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            
            <div class="flex items-center gap-6">
                <a href="{{ url('/docs') }}" class="text-gray-300 hover:text-white nav-link">Docs</a>
                <a href="https://github.com/laravel/laravel" target="_blank" class="text-gray-300 hover:text-white nav-link">GitHub</a>
                
                @if (Route::has('redir'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('redir') }}" class="text-gray-300 hover:text-white mr-4 nav-link">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <div class="hero flex items-center justify-center px-6">
            <div class="particles-container" id="particles"></div>
            <div class="container mx-auto max-w-7xl relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                            Build <span class="gradient-text">Powerful</span> Web Applications
                        </h1>
                        <p class="text-xl text-gray-300 leading-relaxed">
                            Laravel 12 brings exceptional developer experiences and breathtaking performance to your projects. Dive into the future of web development.
                        </p>
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="{{ route('redir') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-indigo-500/30 pulse">
                                Get Started
                            </a>
                            <a href="#features" class="px-8 py-4 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all border border-gray-700">
                                Explore Features
                            </a>
                        </div>
                    </div>

                    <div class="code-block p-1 backdrop-blur">
                        <div class="bg-gray-900 p-4 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <div class="ml-4 text-gray-400 text-sm">Terminal</div>
                            </div>
                            <div class="typewriter overflow-hidden">
                                <pre><code class="text-sm md:text-base text-gray-300">$ <span class="text-green-400">php artisan</span> inspire

<span class="text-indigo-400">▲ "Simplicity is the ultimate sophistication."</span>

$ <span class="text-green-400">php artisan</span> make:controller <span class="text-yellow-300">AwesomeController</span>

<span class="text-indigo-400">✓ Controller created successfully!</span>

$ <span class="text-green-400">php artisan</span> serve

<span class="text-indigo-400">▲ Server running on http://127.0.0.1:8000</span>
</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="features" class="py-24 bg-gradient-to-b from-gray-900 to-gray-950">
            <div class="container mx-auto max-w-7xl px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold gradient-text inline-block mb-6">Engineered for Excellence</h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Laravel 12 combines elegant syntax with powerful features, giving you the tools to build anything from small projects to enterprise applications.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature Cards -->
                    <div class="card bg-gray-900 border border-gray-800 rounded-xl p-6 backdrop-blur">
                        <div class="w-12 h-12 bg-indigo-900/30 rounded-lg flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Lightning Fast</h3>
                        <p class="text-gray-400">
                            Experience blazing performance with the optimized Laravel 12 runtime and Octane server.
                        </p>
                    </div>

                    <div class="card bg-gray-900 border border-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-purple-900/30 rounded-lg flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Developer Joy</h3>
                        <p class="text-gray-400">
                            Elegant syntax and powerful tools make development a delightful experience from start to finish.
                        </p>
                    </div>

                    <div class="card bg-gray-900 border border-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-pink-900/30 rounded-lg flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Security Built-in</h3>
                        <p class="text-gray-400">
                            Robust security features protect your applications from common security threats.
                        </p>
                    </div>

                    <div class="card bg-gray-900 border border-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Elegant Testing</h3>
                        <p class="text-gray-400">
                            Testing is a breeze with Laravel's expressive testing API and built-in tools.
                        </p>
                    </div>

                    <div class="card bg-gray-900 border border-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-green-900/30 rounded-lg flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Global Community</h3>
                        <p class="text-gray-400">
                            Join a vibrant community of millions of developers building incredible applications.
                        </p>
                    </div>

                    <div class="card bg-gray-900 border border-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-red-900/30 rounded-lg flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Comprehensive Documentation</h3>
                        <p class="text-gray-400">
                            Clear, thorough documentation for every feature helps you build with confidence.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-24 bg-gray-950">
            <div class="container mx-auto max-w-7xl px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div class="order-2 md:order-1">
                        <div class="code-block p-1">
                            <div class="bg-gray-900 p-4 rounded-lg">
                                <div class="flex items-center mb-4">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <div class="ml-4 text-gray-400 text-sm">routes/web.php</div>
                                </div>
                                <pre><code class="text-sm text-gray-300">
<span class="text-indigo-400">use</span> <span class="text-green-400">Illuminate\Support\Facades\Route</span>;
<span class="text-indigo-400">use</span> <span class="text-green-400">App\Http\Controllers\AwesomeController</span>;

<span class="text-gray-500">// Define your routes elegantly</span>
<span class="text-indigo-400">Route</span>::<span class="text-cyan-400">get</span>(<span class="text-yellow-300">'/'</span>, <span class="text-indigo-400">function</span> () {
    <span class="text-indigo-400">return</span> <span class="text-indigo-400">view</span>(<span class="text-yellow-300">'welcome'</span>);
});

<span class="text-indigo-400">Route</span>::<span class="text-cyan-400">middleware</span>([<span class="text-yellow-300">'auth'</span>])-><span class="text-cyan-400">group</span>(<span class="text-indigo-400">function</span> () {
    <span class="text-indigo-400">Route</span>::<span class="text-cyan-400">get</span>(<span class="text-yellow-300">'/dashboard'</span>, <span class="text-indigo-400">function</span> () {
        <span class="text-indigo-400">return</span> <span class="text-indigo-400">view</span>(<span class="text-yellow-300">'dashboard'</span>);
    })-><span class="text-cyan-400">name</span>(<span class="text-yellow-300">'dashboard'</span>);
    
    <span class="text-indigo-400">Route</span>::<span class="text-cyan-400">resource</span>(<span class="text-yellow-300">'awesome'</span>, <span class="text-green-400">AwesomeController</span>::<span class="text-cyan-400">class</span>);
});
</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="order-1 md:order-2">
                        <h2 class="text-4xl font-bold mb-6">Elegant <span class="gradient-text">Syntax</span></h2>
                        <p class="text-gray-300 text-lg mb-6">
                            Express your creativity with Laravel's beautiful syntax that makes development a joy. Write code that's both powerful and easy to understand.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">Expressive, clear routing system</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">Intuitive middleware system</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">Powerful resource controllers</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-24 bg-gradient-to-t from-gray-900 to-gray-950">
            <div class="container mx-auto max-w-7xl px-6 text-center">
                <h2 class="text-4xl font-bold mb-8">Ready to <span class="gradient-text">Build Something Amazing</span>?</h2>
                <p class="text-gray-300 text-xl max-w-3xl mx-auto mb-12">
                    Join thousands of developers creating extraordinary applications with Laravel 12. Your journey to better development starts here.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('redir') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-indigo-500/30">
                        Get Started Now
                    </a>
                    <a href="https://laravel.com/docs" class="px-8 py-4 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all border border-gray-700">
                        Read the Docs
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-950 border-t border-gray-800 py-12">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center mb-6">
                        <svg class="h-8 w-8 glow" viewBox="0 0 50 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M49.032 12.96L25.016 0.102L1 12.96V38.676L25.016 51.534L49.032 38.676V12.96Z" fill="#0F172A" stroke="url(#paint2_linear)" stroke-width="2"/>
                            <path d="M25.016 26.037L13.008 19.499V32.137L25.016 38.676L37.024 32.137V19.499L25.016 26.037Z" stroke="url(#paint3_linear)" stroke-width="2"/>
                            <defs>
                                <linearGradient id="paint2_linear" x1="1" y1="25.818" x2="49.032" y2="25.818" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#6366F1"/>
                                    <stop offset="1" stop-color="#EC4899"/>
                                </linearGradient>
                                <linearGradient id="paint3_linear" x1="13.008" y1="29.087" x2="37.024" y2="29.087" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#8B5CF6"/>
                                    <stop offset="1" stop-color="#EC4899"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="ml-3 text-xl font-bold gradient-text">{{ config('app.name', 'Laravel') }}</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        The PHP Framework for Web Artisans, designed for developers who need a beautiful, elegant toolkit to create full-featured web applications.
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="https://laravel.com/docs" class="hover:text-white transition">Documentation</a></li>
                        <li><a href="https://laracasts.com" class="hover:text-white transition">Laracasts</a></li>
                        <li><a href="https://laravel-news.com" class="hover:text-white transition">News</a></li>
                        <li><a href="https://forge.laravel.com" class="hover:text-white transition">Forge</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Community</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="https://github.com/laravel/framework" class="hover:text-white transition">GitHub</a></li>
                        <li><a href="https://laravel.com/docs/contributions" class="hover:text-white transition">Contribute</a></li>
                        <li><a href="https://laravel.com/discord" class="hover:text-white transition">Discord</a></li>
                        <li><a href="https://twitter.com/laravelphp" class="hover:text-white transition">Twitter</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="https://partners.laravel.com" class="hover:text-white transition">Partners</a></li>
                        <li><a href="https://laravel.com/ecosystem" class="hover:text-white transition">Ecosystem</a></li>
                        <li><a href="https://laravel.com/jobs" class="hover:text-white transition">Jobs</a></li>
                        <li><a href="https://laravel.com/contact" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="https://github.com/laravel/laravel" class="text-gray-400 hover:text-white transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="https://twitter.com/laravelphp" class="text-gray-400 hover:text-white transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                        </svg>
                    </a>
                    <a href="https://discord.gg/laravel" class="text-gray-400 hover:text-white transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3847-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for particles effect -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const particlesContainer = document.getElementById('particles');
            const numParticles = 20;
            
            for (let i = 0; i < numParticles; i++) {
                createParticle();
            }
            
            function createParticle() {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 5px and 30px
                const size = Math.random() * 25 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                
                // Random animation duration and delay
                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 5;
                particle.style.animationDuration = `${duration}s`;
                particle.style.animationDelay = `${delay}s`;
                
                // Random opacity
                particle.style.opacity = (Math.random() * 0.5 + 0.1).toString();
                
                particlesContainer.appendChild(particle);
            }
        });
    </script>
</body>
</html>










I created this blade for laravel 12. I really love the ui of my creation. Now I want to turn it into my tech branding 'Horizon'.