<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']); // Ganti 'user_id' sesuai session login kamu
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- ikon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">
    <!-- Header -->
    <header class="flex flex-wrap items-center justify-between px-6 py-4 shadow-md bg-white">
        <div class="flex items-center space-x-3">
            <img src="img/logo_jepretku.png" alt="Logo" class="w-10 h-10" />
            <h1 class="text-xl font-bold">JepretKu</h1>
        </div>
        <nav
            class="w-full md:w-auto flex justify-center md:flex-row space-x-6 mt-4 md:mt-0 text-sm font-medium hidden md:flex">
            <a href="#home" class="hover:text-orange-500 border-b-2 border-orange-500 pb-1">Home</a>
            <a href="#about" class="hover:text-orange-500">About</a>
            <a href="#faq" class="hover:text-orange-500">FAQ</a>
        </nav>
        <div class="space-x-3  md:mt-0">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white bg-gradient-to-br from-orange-400 to-pink-500 p-2 rounded-md">
                Dashboard
            </a>
            @else
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-sm font-bold">
                Register
            </a>
            @endif

            <a href="{{ route('login') }}"
                class="bg-gradient-to-br from-orange-400 to-pink-500 text-white py-2 px-4 rounded text-sm font-bold">
                Log in
            </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="flex flex-col md:flex-row items-center justify-between px-6 md:px-16 py-10 md:py-10" id="home">
        <div class="md:w-1/2 text-center md:text-left space-y-4">
            <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">Capture the Moment,<br />Keep the Memory!</h2>
            <p class="text-gray-700">Make every event unforgettable with our high-quality photobooth experience!</p>
            <a href="{{ route('register') }}"
                class="bg-gradient-to-br from-orange-400 to-pink-500 text-white font-semibold px-6 py-2 rounded-lg inline-block hover:scale-105 hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)]   hover:-translate-y-2 transition-all duration-300">Get
                Started</a>
        </div>
        <div class="md:w-1/2 flex justify-center mt-8 md:mt-0">
            <img src="img/logo_jepretku3D.png" alt="3D Logo" class="w-sm md:w-[500px]">
        </div>
    </section>

    <!-- Features Section -->
    <section class="text-center px-8 py-10 md:mt-12">
        <h2 class="text-2xl font-bold mb-2">Why Choose Our Photobooth?</h2>
        <p class="mb-8">We bring fun, creativity, and high-quality instant prints to your special moments!</p>

        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-4 justify-center">
            <div class="bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] 
                hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-lg font-bold mb-2">
                    <span class="material-symbols-outlined" style="font-size: 40px;">
                        photo_camera
                    </span>
                    <br>Snap & Capture
                </h3>
                <p>Instantly take high-quality photos using our device or photobooth.</p>
            </div>
            <div class="bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] 
                hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-lg font-bold mb-2">
                    <span class="material-symbols-outlined" style="font-size: 40px;">
                        palette
                    </span>
                    <br>Photo Effect & Filters
                </h3>
                <p>Enhance your pictures with fun filters and creative effects.</p>
            </div>
            <div class="bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] 
                hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-lg font-bold mb-2">
                    <span class="material-symbols-outlined" style="font-size: 40px;">
                        history
                    </span>
                    <br>Photo History Access
                </h3>
                <p>Revisit, download, and relive all your past photo moments.</p>
            </div>
            <div class="bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] 
                hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-lg font-bold mb-2">
                    <span class="material-symbols-outlined" style="font-size: 40px;">
                        share
                    </span>
                    <br>One Click Sharing
                </h3>
                <p>Instantly share your best shots on Instagram, Whatsapp, and more.</p>
            </div>
        </div>

        <div class="mt-10">
            <p class="font-bold">Your Best Moments, Captured Instantly!</p>
            <p
                class="bg-gradient-to-r from-orange-400 via-pink-500 to-pink-400 bg-clip-text text-transparent font-bold text-lg">
                Snap, Edit & Share – Try it Now</p>
        </div>
    </section>

    <!-- Tutorial Section -->
    <section class="text-center px-4 py-10" id="about">
        <h2 class="text-2xl font-bold mb-4">Tutorial</h2>
        <p>Learn how to use our photobooth step by step with ease!</p>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="text-center px-4 py-10">
        <h2 class="text-2xl font-bold mb-4">FAQ</h2>
        <p class="mb-6">Find answers to common questions about our service.</p>
        <div class="max-w-md mx-auto space-y-4 text-left">
            <div class="faq-item border rounded-lg overflow-hidden">
                <button
                    class="faq-question w-full bg-gradient-to-r from-orange-400 to-pink-500 text-white px-4 py-3 font-semibold text-left">Apa
                    itu JepretKu?</button>
                <div class="faq-answer hidden px-4 py-3 bg-orange-50 text-gray-700">JepretKu adalah layanan photobooth
                    online yang memudahkan pengguna mengambil foto, edit, dan bagikan dengan mudah.</div>
            </div>
            <div class="faq-item border rounded-lg overflow-hidden">
                <button
                    class="faq-question w-full bg-gradient-to-r from-orange-400 to-pink-500 text-white px-4 py-3 font-semibold text-left">Apakah
                    saya harus daftar?</button>
                <div class="faq-answer hidden px-4 py-3 bg-orange-50 text-gray-700">Ya, Anda perlu mendaftar agar dapat
                    mengakses riwayat foto dan fitur premium lainnya.</div>
            </div>
            <div class="faq-item border rounded-lg overflow-hidden">
                <button
                    class="faq-question w-full bg-gradient-to-r from-orange-400 to-pink-500 text-white px-4 py-3 font-semibold text-left">Bisakah
                    saya mengunduh foto saya?</button>
                <div class="faq-answer hidden px-4 py-3 bg-orange-50 text-gray-700">Ya, semua foto yang Anda ambil dapat
                    diunduh langsung dari akun Anda.</div>
            </div>
        </div>
    </section>

    <!-- FAQ JS -->
    <script>
        document.querySelectorAll(".faq-question").forEach((btn) => {
            btn.addEventListener("click", () => {
                const item = btn.parentElement;
                const answer = item.querySelector(".faq-answer");
                answer.classList.toggle("hidden");
            });
        });
    </script>
</body>

</html>