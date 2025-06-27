<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - JepretKu </title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* CSS untuk Animasi Scroll (Fade-in & Slide-up) */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* CSS untuk Animasi Auto-Scroll Horizontal (Marquee) */
        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Kelas untuk item yang akan di-scroll */
        .animate-marquee {
            animation: marquee 80s linear infinite;
        }

        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>

    <script>
        document.documentElement.style.scrollBehavior = 'auto';

        window.addEventListener('load', () => {
            setTimeout(() => {
                document.documentElement.style.scrollBehavior = 'smooth';
            }, 0);
        });
    </script>


    @vite(['resources/css/app.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-700">
    <header class="sticky top-0 z-50 flex flex-wrap items-center justify-between px-6 py-4 shadow-md bg-white/80 backdrop-blur-sm">
        <div class="flex items-center space-x-3">
            <img src="img/logo_jepretku.png" alt="Logo" class="w-10 h-10" />
            <h1 class="text-xl font-bold hover:text-orange-400"> Jepret<span class=" text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-pink-500">Ku</span></h1>
        </div>
        <nav class="w-full md:w-auto md:flex-row space-x-8 mt-4 md:mt-0 text-sm font-medium hidden md:flex">
            <a href="#home" class="hover:text-orange-500 transition-colors">Beranda</a>
            <a href="#features" class="hover:text-orange-500 transition-colors">Fitur</a>
            <a href="#gallery" class="hover:text-orange-500 transition-colors">Galeri</a>
            <a href="#faq" class="hover:text-orange-500 transition-colors">FAQ</a>
        </nav>
        <div class="space-x-3 md:mt-0">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white bg-gradient-to-br from-orange-400 to-pink-500 px-4 py-2 rounded-md hover:shadow-lg hover:shadow-orange-400/30 transition-shadow">
                Dashboard
            </a>
            @else
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-sm font-bold hover:text-orange-500 transition-colors">
                Daftar
            </a>
            @endif

            <a href="{{ route('login') }}" class="bg-gradient-to-br from-orange-400 to-pink-500 text-white py-2 px-4 rounded text-sm font-bold hover:shadow-lg hover:shadow-orange-400/30 hover:scale-110 transform transition-all duration-300 inline-block">
                Masuk
            </a>
            @endauth
        </div>
    </header>

    <section class="flex flex-col md:flex-row items-center justify-between px-6 md:px-16 py-16 md:py-24" id="home">
        <div class="md:w-1/2 text-center md:text-left space-y-5 reveal">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight"> <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-pink-500">Abadikan</span> Momenmu,<br />Simpan <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-pink-500">Kenangannya</span></h2>
            <p class="text-gray-600 text-lg">Abadikan setiap momen tak terlupakan dengan pengalaman photobooth yang berkualitas!</p>
            <a href="{{ route('register') }}" class="bg-gradient-to-br from-orange-400 to-pink-500 text-white font-semibold px-8 py-3 rounded-lg inline-block hover:scale-105 hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.3)] hover:-translate-y-1 transition-all duration-300">
                Mulai Sekarang
            </a>
        </div>
        <div class="md:w-1/2 flex justify-center mt-12 md:mt-0 reveal" style="transition-delay: 200ms;">
            <img src="img/logo_jepretku3D.png" alt="3D Logo" class="w-sm md:w-[500px]">
        </div>
    </section>

    <section class="text-center px-8 py-20 md:mt-12" id="features">
        <div class="reveal">
            <h2 class="text-3xl font-bold mb-3">Kenapa memilih Photobooh Kami?</h2>
            <p class="mb-12 text-gray-600 max-w-2xl mx-auto">Kami membawa keseruan, kreativitas, dan hasil cetak instan terbaik ke momen-momen spesial Anda!</p>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-4 justify-center">
            <div class="reveal bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] hover:-translate-y-2 transition-all duration-300" style="transition-delay: 100ms;">
                <h3 class="text-lg font-bold mb-2"><span class="material-symbols-outlined text-4xl">photo_camera</span><br>Ambil Foto</h3>
                <p>Ambil foto berkualitas tinggi secara instan menggunakan perangkat atau photobooth kami.</p>
            </div>
            <div class="reveal bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] hover:-translate-y-2 transition-all duration-300" style="transition-delay: 200ms;">
                <h3 class="text-lg font-bold mb-2"><span class="material-symbols-outlined text-4xl">palette</span><br>Efek dan Filter Foto</h3>
                <p>Percantik fotomu dengan filter seru dan efek yang kreatif.</p>
            </div>
            <div class="reveal bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] hover:-translate-y-2 transition-all duration-300" style="transition-delay: 300ms;">
                <h3 class="text-lg font-bold mb-2"><span class="material-symbols-outlined text-4xl">history</span><br>Akses Riwayat Foto</h3>
                <p>Lihat kembali, unduh, dan hidupkan lagi semua momen foto Anda yang telah lalu.</p>
            </div>
            <div class="reveal bg-gradient-to-br from-orange-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)] hover:-translate-y-2 transition-all duration-300" style="transition-delay: 400ms;">
                <h3 class="text-lg font-bold mb-2"><span class="material-symbols-outlined text-4xl">share</span><br>Berbagi Sekali Klik</h3>
                <p>Langsung bagikan foto-foto terbaikmu ke Instagram, Whatsapp, dan platform lainnya.</p>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-20 bg-white overflow-hidden">
        <div class="container mx-auto px-6 reveal">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Galeri Penuh <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-pink-500">Kreasi</span></h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Lihat momen-momen seru yang diabadikan oleh pengguna JepretKu secara live!</p>
            </div>
        </div>

        <div class="relative w-full flex overflow-hidden group">
            <div class="flex animate-marquee group-hover:paused">
                <div class="flex-shrink-0 flex space-x-8 px-4">
                    <img src="img/photo1.jpg" alt="Kreasi JepretKu 1" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo2.jpg" alt="Kreasi JepretKu 2" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo3.jpg" alt="Kreasi JepretKu 3" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo4.jpg" alt="Kreasi JepretKu 4" class="w-72 h-96 object-cover bg-slate-200  rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo5.jpg" alt="Kreasi JepretKu 5" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo6.jpg" alt="Kreasi JepretKu 6" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                </div>
                <div class="flex-shrink-0 flex space-x-8 px-4" aria-hidden="true">
                    <img src="img/photo1.jpg" alt="Kreasi JepretKu 1" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo2.jpg" alt="Kreasi JepretKu 2" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo3.jpg" alt="Kreasi JepretKu 3" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo4.jpg" alt="Kreasi JepretKu 4" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo5.jpg" alt="Kreasi JepretKu 5" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <img src="img/photo6.jpg" alt="Kreasi JepretKu 6" class="w-72 h-96 object-cover bg-slate-200 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 reveal">
                <h2 class="text-3xl font-bold mb-3">Frequently Asked Questions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Punya pertanyaan? Kami punya jawabannya. Cek daftar di bawah ini.</p>
            </div>
            <div class="max-w-3xl mx-auto space-y-4">
                <div class="reveal faq-item border-2 border-orange-100 rounded-lg overflow-hidden" style="transition-delay: 100ms;">
                    <button class="faq-question w-full flex justify-between items-center bg-white px-6 py-4 font-semibold text-left">
                        <span>Apa itu JepretKu?</span>
                        <span class="material-symbols-outlined transition-transform duration-300">expand_more</span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <p class="px-6 pb-4 pt-2 text-gray-600">JepretKu adalah layanan photobooth online yang memudahkan pengguna mengambil foto, memberikan efek, dan membagikannya dengan mudah.</p>
                    </div>
                </div>
                <div class="reveal faq-item border-2 border-orange-100 rounded-lg overflow-hidden" style="transition-delay: 200ms;">
                    <button class="faq-question w-full flex justify-between items-center bg-white px-6 py-4 font-semibold text-left">
                        <span>Apakah saya harus mendaftar?</span>
                        <span class="material-symbols-outlined transition-transform duration-300">expand_more</span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <p class="px-6 pb-4 pt-2 text-gray-600">Ya, Anda perlu mendaftar untuk dapat mengakses riwayat foto Anda dan fitur-fitur lainnya. Pendaftaran cepat dan mudah!</p>
                    </div>
                </div>
                <div class="reveal faq-item border-2 border-orange-100 rounded-lg overflow-hidden" style="transition-delay: 300ms;">
                    <button class="faq-question w-full flex justify-between items-center bg-white px-6 py-4 font-semibold text-left">
                        <span>Bisakah saya mengunduh foto saya?</span>
                        <span class="material-symbols-outlined transition-transform duration-300">expand_more</span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <p class="px-6 pb-4 pt-2 text-gray-600">Tentu saja! Semua foto yang Anda ambil dapat diunduh dalam resolusi tinggi langsung dari galeri di dashboard akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-200">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="col-span-1 lg:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="img/logo_jepretku.png" alt="Logo" class="w-10 h-10" />
                        <h1 class="text-xl font-bold">Jepret<span class=" text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-pink-500">Ku</span></h1>
                    </div>
                    <p class="text-gray-600 mb-4">Abadikan setiap momen berharga dan ciptakan kenangan tak terlupakan bersama kami.</p>
                    <div class="flex space-x-4">
                        <a href="https://github.com/riyhs/jepretku" class="text-gray-500 hover:text-orange-500 transition-colors" aria-label="GitHub">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.164 6.839 9.489.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.378.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.942.359.308.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-span-1">
                    <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#home" class="hover:text-orange-500 hover:underline">Beranda</a></li>
                        <li><a href="#features" class="hover:text-orange-500 hover:underline">Fitur</a></li>
                        <li><a href="#gallery" class="hover:text-orange-500 hover:underline">Galeri</a></li>
                        <li><a href="#faq" class="hover:text-orange-500 hover:underline">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <h3 class="font-bold text-lg mb-4">Stay Updated</h3>
                    <p class="text-gray-600 mb-4">Dapatkan info terbaru langsung ke email Anda.</p>
                    <form action="#" class="flex">
                        <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <button type="submit" class="bg-gradient-to-br from-orange-400 to-pink-500 text-white font-bold px-4 py-2 rounded-r-md hover:opacity-90 transition-opacity">Go</button>
                    </form>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-200 pt-6 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} JepretKu. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // --- Animasi Scroll ---
            const revealElements = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            revealElements.forEach(element => {
                observer.observe(element);
            });

            // --- FAQ Accordion ---
            document.querySelectorAll(".faq-question").forEach((button) => {
                button.addEventListener("click", () => {
                    const answer = button.nextElementSibling;
                    const icon = button.querySelector(".material-symbols-outlined");

                    if (answer.style.maxHeight) {
                        answer.style.maxHeight = null;
                        icon.style.transform = "rotate(0deg)";
                    } else {
                        answer.style.maxHeight = answer.scrollHeight + "px";
                        icon.style.transform = "rotate(180deg)";
                    }
                });
            });

        });
    </script>
</body>

</html>