<?php
require_once 'db_connect.php';

$activePage = 'about';
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About – AGGRO Smart Coffee Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assests/variables.css" />
    <link rel="stylesheet" href="assests/about.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>

<body>
    <nav class="fixed top-0 left-0 right-0 z-50 nav-fixed" id="navbar">
      <div class="max-w-[1540px] mx-auto px-6 w-full py-8 flex items-center justify-between">
        <a href="index.php" class="logo text-white text-4xl tracking-widest" style="letter-spacing: 0.12em">AGGRO</a>

        <div class="hidden md:flex items-center gap-8">
          <a href="services.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">Services</a>
          <a href="product.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">Shop</a>
          <a href="about.php" class="text-white text-xl font-medium transition-colors pb-0.5">About</a>
        </div>

        <a href="contact.php" class="btn-outline text-xl">Contact Us</a>
      </div>
    </nav>

    <section class="about-hero w-full min-h-screen flex flex-col justify-end pb-24 pt-36 rounded-b-[30px] overflow-hidden relative">
      <div class="grain-overlay absolute inset-0 pointer-events-none z-10"></div>

      <div id="badge-anchor" class="absolute top-0 right-8 md:right-20 z-20 flex flex-col items-center">
        <div id="badge-pendulum" class="pendulum-wrapper">
          <div class="badge-string"></div>
          <div class="est-badge">
            <span class="est-text">EST.</span>
            <span class="est-year">2019</span>
          </div>
        </div>
      </div>

      <div class="max-w-[1540px] mx-auto px-6 w-full relative z-20">
        <div class="flex flex-col gap-10">
          <div class="anim-1">
            <p class="about-eyebrow mb-4">Our Story</p>
            <h1 class="about-hero-title anim-2">
              Rooted in the<br />
              <span class="text-[#8C5A3C]">Highlands,</span><br />
              Perfected by Data.
            </h1>
          </div>

          <div class="anim-3 flex flex-col md:flex-row gap-8 md:gap-24 items-start">
            <p class="about-hero-sub max-w-md">
              Lahir dari lereng vulkanik Sumatera, AGGRO didirikan oleh para penikmat kopi yang menolak untuk memilih antara tradisi bertani dan teknologi presisi.
            </p>
            <div class="flex flex-col gap-2">
              <div class="divider-line"></div>
              <p class="about-hero-sub max-w-sm">
                Kini, kami menyajikan kopi <i>specialty</i> untuk lebih dari 10.000 pelanggan dan 400 mitra B2B di seluruh Indonesia — <i>smarter sourcing, better roasting, higher cup scores.</i>
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 scroll-indicator">
        <div class="scroll-dot"></div>
      </div>
    </section>

    <section class="manifesto-section py-20 px-6 overflow-hidden">
      <div class="max-w-[1540px] mx-auto">
        <div class="manifesto-grid">
          <div class="manifesto-left">
            <span class="quote-mark">"</span>
            <blockquote class="manifesto-quote">
              We believe every coffee bean deserves to reach its full flavor potential — and so does every cup you brew.
            </blockquote>
            <div class="quote-attr">
              <span class="attr-name">Rafi Adinugroho</span>
              <span class="attr-role">Founder & Head Roaster, AGGRO</span>
            </div>
          </div>

          <div class="manifesto-right">
            <div class="manifesto-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=900&q=80"
                alt="Coffee farm aerial"
                class="manifesto-img"
              />
              <div class="manifesto-img-label">
                <span>Gayo Highlands, Aceh</span>
                <span>1,400 MASL</span>
              </div>
            </div>
            <p class="manifesto-deco-num">05</p>
          </div>
        </div>
      </div>
    </section>

    <section class="origin-section py-20 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="origin-header mb-16">
          <span class="section-tag">Origin Story</span>
          <h2 class="section-heading-dark">From the<br />Ground Up.</h2>
        </div>

        <div class="origin-timeline">
          <div class="timeline-item left">
            <div class="timeline-year">2019</div>
            <div class="timeline-content">
              <h3 class="timeline-title">The First Batch</h3>
              <p class="timeline-body">
                AGGRO bermula sebagai eksperimen di garasi kecil. Founder kami, Rafi Adinugroho, mencari profil <i>roasting</i> yang paling sempurna untuk biji Arabica Toraja dengan merakit sensor suhu DIY pada mesin <i>roaster</i> tua miliknya. Tujuannya satu: konsistensi rasa yang absolut.
              </p>
            </div>
          </div>

          <div class="timeline-item right">
            <div class="timeline-year">2021</div>
            <div class="timeline-content">
              <h3 class="timeline-title">The Subscription Era</h3>
              <p class="timeline-body">
                Setelah memenangkan penghargaan di kompetisi <i>roasting</i> nasional, permintaan mulai membludak. Kami meluncurkan platform <i>coffee subscription</i> AGGRO v1.0, mengirimkan <i>freshly roasted beans</i> ke ratusan penikmat kopi rumahan (<i>home brewers</i>) setiap bulannya.
              </p>
            </div>
          </div>

          <div class="timeline-item left">
            <div class="timeline-year">2023</div>
            <div class="timeline-content">
              <h3 class="timeline-title">Wholesale Expansion</h3>
              <p class="timeline-body">
                Kualitas konsisten kami menarik perhatian industri F&B. AGGRO berekspansi menjadi mitra B2B untuk menyuplai kafe, hotel, dan restoran. Kami mulai bekerja langsung secara <i>direct-trade</i> dengan kelompok tani di Sumatera dan Jawa untuk mengamankan suplai biji hijau berkualitas.
              </p>
            </div>
          </div>

          <div class="timeline-item right active">
            <div class="timeline-year">Now</div>
            <div class="timeline-content">
              <h3 class="timeline-title">10k+ Cups, One Mission</h3>
              <p class="timeline-body">
                Hari ini, AGGRO mengkurasi dan menyangrai kopi untuk lebih dari 10.000 pelanggan aktif dan ratusan mitra <i>wholesale</i>. Dengan tim <i>Q-Grader</i> bersertifikat dan ekosistem berbasis data, misi kami tetap sama: menyajikan kopi terbaik di setiap cangkir.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="values-section py-20 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="values-header mb-20">
          <span class="section-tag-light">What We Stand For</span>
          <div class="values-header-row">
            <h2 class="section-heading-light">Our<br />Core Values.</h2>
            <p class="values-subtext">
              Setiap biji kopi yang kami sangrai dan kami kirimkan berakar kuat pada empat prinsip dasar ini. Ini bukan sekadar slogan, melainkan standar operasional harian kami.
            </p>
          </div>
        </div>

        <div class="values-grid">
          <div class="value-card">
            <div class="value-num">01</div>
            <i class="value-icon fa-solid fa-leaf fa-xl" style="color: rgb(255, 255, 255)"></i>
            <h3 class="value-title">Sourcing First</h3>
            <p class="value-body">
              Kopi hebat dimulai dari tanah. Kami menerapkan praktik <i>direct trade</i>, bekerja langsung dengan petani untuk memastikan mereka dibayar dengan harga premium untuk biji dengan kualitas terbaik.
            </p>
          </div>

          <div class="value-card accent">
            <div class="value-num">02</div>
            <i class="value-icon fa-solid fa-laptop-code fa-xl" style="color: rgb(255, 255, 255)"></i>
            <h3 class="value-title">Data-Driven Roasting</h3>
            <p class="value-body">
              Insting seorang <i>roaster</i> itu penting, tetapi kami menyempurnakannya dengan data presisi. Setiap profil sangrai kami dilacak secara digital untuk memastikan konsistensi rasa yang absolut di setiap <i>batch</i>.
            </p>
          </div>

          <div class="value-card">
            <div class="value-num">03</div>
            <i class="value-icon fa-solid fa-mug-saucer fa-xl" style="color: rgb(255, 255, 255)"></i>
            <h3 class="value-title">Cup Quality is Sacred</h3>
            <p class="value-body">
              Kami tidak berkompromi soal rasa. Setiap rilis baru harus melewati sesi <i>cupping</i> ketat oleh panel <i>Q-Grader</i> kami. Jika skornya tidak memenuhi standar <i>specialty</i>, kami tidak akan menjualnya.
            </p>
          </div>

          <div class="value-card">
            <div class="value-num">04</div>
            <i class="value-icon fa-solid fa-users fa-xl" style="color: rgb(255, 255, 255)"></i>
            <h3 class="value-title">Community & Partners</h3>
            <p class="value-body">
              Kami bukan sekadar pemasok. Baik Anda seorang <i>home brewer</i> yang berlangganan bulanan, maupun pemilik kafe, kami menganggap Anda sebagai mitra dalam mengeksekusi seduhan yang sempurna.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="team-section py-20 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="team-header mb-20">
          <div class="team-header-left">
            <span class="section-tag">The People</span>
            <h2 class="section-heading-dark">
              Meet the<br />Minds Behind<br />the Roaster.
            </h2>
          </div>
          <p class="team-intro-text">
            Tim kami adalah perpaduan langka — <i>roasters</i> yang obsesif pada detail rasa, <i>green buyers</i> yang memahami iklim kebun, dan ahli data yang memastikan semuanya terkalibrasi. Ini adalah <i>unfair advantage</i> kami.
          </p>
        </div>

        <div class="team-grid">
          <div class="team-card featured">
            <div class="team-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80"
                alt="Rafi"
                class="team-img"
              />
              <div class="team-img-overlay"></div>
            </div>
            <div class="team-info">
              <p class="team-name">Rafi Adinugroho</p>
              <p class="team-role">Founder & Head Roaster</p>
              <p class="team-bio">
                10+ tahun pengalaman di industri kopi. Q-Grader bersertifikat. Pendiri visi AGGRO untuk memadukan data sains dengan <i>specialty coffee</i>.
              </p>
            </div>
          </div>

          <div class="team-card">
            <div class="team-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&q=80"
                alt="Sari"
                class="team-img"
              />
              <div class="team-img-overlay"></div>
            </div>
            <div class="team-info">
              <p class="team-name">Sari Handayani</p>
              <p class="team-role">Lead Quality Control</p>
              <p class="team-bio">
                Pakar sensorik di balik setiap kurasi biji kami. Bertanggung jawab atas sesi <i>cupping</i> harian dan penentuan <i>tasting notes</i>.
              </p>
            </div>
          </div>

          <div class="team-card">
            <div class="team-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&q=80"
                alt="Bima"
                class="team-img"
              />
              <div class="team-img-overlay"></div>
            </div>
            <div class="team-info">
              <p class="team-name">Bima Satria</p>
              <p class="team-role">Green Bean Buyer</p>
              <p class="team-bio">
                Ujung tombak <i>direct-trade</i> kami. Menghabiskan sebagian besar waktunya di dataran tinggi untuk berkolaborasi dengan kelompok tani.
              </p>
            </div>
          </div>

          <div class="team-card">
            <div class="team-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&q=80"
                alt="Laras"
                class="team-img"
              />
              <div class="team-img-overlay"></div>
            </div>
            <div class="team-info">
              <p class="team-name">Laras Cahyaningrum</p>
              <p class="team-role">Head of Wholesale / B2B</p>
              <p class="team-bio">
                Penghubung utama dengan ratusan kafe mitra kami. Memastikan kalibrasi mesin dan suplai kopi di bisnis Anda berjalan tanpa hambatan.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="metrics-band py-24 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="metrics-row">
          <div class="metric-item">
            <p class="metric-num">10<span class="metric-unit">k+</span></p>
            <p class="metric-label">Active Subscribers</p>
          </div>

          <div class="metric-divider"></div>

          <div class="metric-item">
            <p class="metric-num">86<span class="metric-plus">+</span></p>
            <p class="metric-label">Average Cup Score</p>
          </div>

          <div class="metric-divider"></div>

          <div class="metric-item">
            <p class="metric-num">400<span class="metric-plus">+</span></p>
            <p class="metric-label">B2B Wholesale Partners</p>
          </div>

          <div class="metric-divider"></div>

          <div class="metric-item">
            <p class="metric-num">100<span class="metric-unit">%</span></p>
            <p class="metric-label">Freshly Roasted</p>
          </div>
        </div>
      </div>
    </section>

    <section class="cta-section py-32 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="cta-inner">
          <img
            src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=1400&q=80"
            alt="Coffee farm"
            class="cta-bg-img"
          />
          <div class="cta-overlay"></div>

          <div class="cta-content">
            <h2 class="cta-heading">
              Your Best Cup<br />Starts With<br />A Conversation.
            </h2>
            <p class="cta-sub">
              Tertarik berlangganan untuk di rumah atau butuh suplai kopi untuk kafe Anda? Beritahu kami kebutuhan rasa dan volume Anda. Tim ahli kami siap membantu.
            </p>
            <div class="cta-actions">
              <a href="#" class="btn-lime-cta">Talk to a Coffee Expert</a>
              <a href="#" class="btn-ghost-cta">Explore Shop →</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="py-11 px-6 md:px-10">
      <div class="max-w-[1540px] mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-x-8 gap-y-10">

          <div class="col-span-2 md:col-span-1 flex flex-col gap-3">
            <h2 class="logo text-[2.6rem] tracking-tight text-black leading-none">
              AGGRO
            </h2>
            <p class="font-body text-[0.82rem] text-[#6b6b6b] leading-relaxed max-w-[200px]">
              Menjaga tradisi, merangkul <i>modern innovations</i> untuk industri kopi yang lebih baik.
            </p>
            <div class="flex gap-4 mt-2">
              <a href="#" class="social-icon"><i class="fa-brands fa-instagram text-[#6b6b6b] hover:text-[#C08552]"></i></a>
              <a href="#" class="social-icon"><i class="fa-brands fa-linkedin text-[#6b6b6b] hover:text-[#C08552]"></i></a>
              <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter text-[#6b6b6b] hover:text-[#C08552]"></i></a>
            </div>
          </div>

          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">Shop</h3>
            <ul class="flex flex-col gap-2">
              <li><a href="#" class="nav-link text-black font-body text-sm">All Coffee</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Subscriptions</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Smart Accessories</a></li>
            </ul>
          </div>

          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">Company</h3>
            <ul class="flex flex-col gap-2">
              <li><a href="about.php" class="nav-link text-black font-body text-sm">About Us</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Contact</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Careers</a></li>
            </ul>
          </div>

          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">Services</h3>
            <ul class="flex flex-col gap-2">
              <li><a href="#" class="nav-link text-black font-body text-sm">Wholesale B2B</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Private Label</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Barista Training</a></li>
            </ul>
          </div>

          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">Support</h3>
            <ul class="flex flex-col gap-2">
              <li><a href="#" class="nav-link text-black font-body text-sm">Shipping Policy</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Help Center</a></li>
              <li><a href="#" class="nav-link text-black font-body text-sm">Return Policy</a></li>
            </ul>
          </div>

        </div>
        
        <div class="border-t border-gray-200 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
          <p class="font-body text-xs text-gray-400">© 2026 AGGRO. All rights reserved.</p>
          <div class="flex gap-6">
            <a href="#" class="font-body text-xs text-gray-400 hover:text-gray-600 transition-colors">Privacy Policy</a>
            <a href="#" class="font-body text-xs text-gray-400 hover:text-gray-600 transition-colors">Terms of Service</a>
          </div>
        </div>
      </div>
    </footer>
  </body>
  <script src="assests/js/badge-animation.js"></script>
  <script src="assests/js/navbar-scrollbar.js"></script>
</html>