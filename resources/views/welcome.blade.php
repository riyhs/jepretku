<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JepretKu - Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff;
      color: #111;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 20px;
      border-bottom: 1px solid #eee;
    }

    .header-left {
      display: flex;
      align-items: center;
    }

    .logo {
      height: 40px;
      margin-right: 10px;
    }

    .brand-name {
      font-weight: 700;
      font-size: 1.2rem;
    }

    nav {
      display: flex;
      gap: 15px;
    }

    nav a {
      text-decoration: none;
      color: #111;
      font-weight: 600;
      position: relative;
    }

    nav a:hover,
    nav a.active {
      color: #ff6600;
    }

    nav a.active::after {
      content: "";
      position: absolute;
      width: 100%;
      height: 2px;
      background: #ff6600;
      bottom: -5px;
      left: 0;
    }

    .auth-buttons a {
      text-decoration: none;
      margin-left: 10px;
      padding: 8px 15px;
      border-radius: 10px;
      font-weight: 600;
      color: white;
      background-color: #ff7a00;
      transition: 0.3s;
    }

    .auth-buttons a:hover {
      background-color: #e55c00;
      transform: scale(1.05);
    }

    .hero {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
      background-color: #fff;
      text-align: center;
    }

    .hero-text {
      max-width: 600px;
    }

    .hero-text h1 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .hero-text p {
      font-size: 1rem;
      margin-bottom: 20px;
    }

    .hero-text .get-started {
      padding: 10px 20px;
      background-color: #ff7a00;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .hero-text .get-started:hover {
      background-color: #e55c00;
      transform: scale(1.05);
    }

    .hero-image img {
      width: 200px;
      margin-top: 30px;
    }

    .features {
      text-align: center;
      padding: 40px 20px;
    }

    .features-title {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .features-title img {
      height: 60px;
    }

    .feature-boxes {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      margin-top: 30px;
    }

    .feature-box {
      background: linear-gradient(135deg, #ff9900, #ff5e62);
      color: white;
      padding: 20px;
      border-radius: 20px;
      width: 90%;
      max-width: 300px;
      text-align: center;
      box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .feature-box:hover {
      transform: translateY(-5px);
    }

    .features-caption {
      margin-top: 40px;
      font-size: 1rem;
    }

    .gradient-text {
      background: linear-gradient(to right, #ff9900, #ff5e62, #e60073);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: bold;
    }

    .section {
      padding: 40px 20px;
      margin-bottom: 40px;
    }

    .section h2 {
      font-size: 1.5rem;
      margin-bottom: 20px;
      font-weight: 700;
    }

    .faq, .tutorial {
      text-align: center;
    }

    /* FAQ Accordion */
    .faq-item {
      text-align: left;
      margin-bottom: 15px;
      width: 100%;
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    .faq-question {
      width: 100%;
      background: linear-gradient(to right, #ff9900, #ff5e62);
      color: white;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      text-align: left;
    }

    .faq-answer {
      display: none;
      padding: 10px 15px;
      background: #fff3e0;
      border-radius: 10px;
      margin-top: 5px;
      color: #333;
    }

    .faq-item.active .faq-answer {
      display: block;
    }

    /* Responsive tweaks */
    @media (min-width: 768px) {
      .hero {
        flex-direction: row;
        justify-content: space-between;
        text-align: left;
        padding: 60px 50px;
      }

      .hero-text {
        max-width: 50%;
      }

      .hero-image img {
        width: 300px;
      }

      .feature-boxes {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
      }

      .feature-box {
        width: 200px;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="header-left">
      <img src="logo_jepretku.png" alt="Logo" class="logo">
      <span class="brand-name">JepretKu</span>
    </div>
    <nav>
      <a href="#" class="active">Home</a>
      <a href="#">About</a>
      <a href="#faq">FAQ</a>
    </nav>
    <div class="auth-buttons">
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Capture the Moment,<br>Keep the Memory!</h1>
      <p>Make every event unforgettable with our high-quality photobooth experience.</p>
      <button class="get-started">Get Started</button>
    </div>
    <div class="hero-image">
      <img src="logo_jepretku3d.png" alt="3D Logo">
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <div class="features-title">
      <h2>Why Choose Our Photobooth ?</h2>
    </div>
    <p>We bring fun, creativity, and high-quality instant prints to your special moments!</p>

    <div class="feature-boxes">
      <div class="feature-box">
        <h3>📸<br>Snap & Capture</h3>
        <p>Instantly take high-quality photos using our device or photobooth.</p>
      </div>
      <div class="feature-box">
        <h3>🎨<br>Photo Effect & Filters</h3>
        <p>Enhance your pictures with fun filters and creative effects.</p>
      </div>
      <div class="feature-box">
        <h3>🕓<br>Photo History Access</h3>
        <p>Revisit, download, and relive all your past photo moments.</p>
      </div>
      <div class="feature-box">
        <h3>📤<br>One Click Sharing</h3>
        <p>Instantly share your best shots on Instagram, Whatsapp, and more.</p>
      </div>
    </div>

    <div class="features-caption">
      <p><strong>Your Best Moments, Captured Instantly!</strong></p>
      <p class="gradient-text">Snap, Edit & Share – Try it Now</p>
    </div>
  </section>

  <!-- Tutorial Section -->
  <section class="section tutorial" id="tutorial">
    <h2>Tutorial</h2>
    <p>Learn how to use our photobooth step by step with ease!</p>
    <!-- Video or tutorial steps could be added here -->
  </section>

  <!-- FAQ Section -->
  <section class="section faq" id="faq">
    <h2>FAQ</h2>
    <p>Find answers to common questions about our service.</p>

    <div class="faq-item">
      <button class="faq-question">Apa itu JepretKu?</button>
      <div class="faq-answer">
        <p>JepretKu adalah layanan photobooth online yang memudahkan pengguna mengambil foto, edit, dan bagikan dengan mudah.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">Apakah saya harus daftar?</button>
      <div class="faq-answer">
        <p>Ya, Anda perlu mendaftar agar dapat mengakses riwayat foto dan fitur premium lainnya.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">Bisakah saya mengunduh foto saya?</button>
      <div class="faq-answer">
        <p>Ya, semua foto yang Anda ambil dapat diunduh langsung dari akun Anda.</p>
      </div>
    </div>
  </section>

  <!-- FAQ JS -->
  <script>
    document.querySelectorAll(".faq-question").forEach((btn) =>
      btn.addEventListener("click", () => {
        btn.parentElement.classList.toggle("active");
      })
    );
  </script>

</body>
</html>
