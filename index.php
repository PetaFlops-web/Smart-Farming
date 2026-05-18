<?php
require_once 'db_connect.php';
// index.php - AGGRO Homepage
$page_title = "AGGRO – Expert Advisory For Smarter Farming";
$page_lang  = "id";
?>
<!doctype html>
<html lang="<?php echo $page_lang; ?>">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="assests/variables.css" />
    <link rel="stylesheet" href="assests/home.css" />
    <script src="assests/tailwind-config.js"></script>
  </head>

  <body class="text-white overflow-x-hidden">
    <nav class="fixed top-0 left-0 right-0 z-50 nav-fixed" id="navbar">
      <div
        class="max-w-[1540px] mx-auto px-6 w-full py-8 flex items-center justify-between"
      >
        <a
          href="index.php"
          class="logo text-white text-4xl tracking-widest"
          style="letter-spacing: 0.12em"
          >AGGRO</a
        >

        <div class="hidden md:flex items-center gap-8">
          <a
            href="services.php"
            class="text-white/80 hover:text-white text-xl font-medium transition-colors"
            >Services</a
          >
          <a
            href="product.php"
            class="text-white/80 hover:text-white text-xl font-medium transition-colors"
            >Shop</a
          >
          <a
            href="about.php"
            class="text-white text-xl font-medium transition-colors pb-0.5"
            >About</a
          >
        </div>

        <a href="contact.php" class="btn-outline text-xl">Contact Us</a>
      </div>
    </nav>

    <section
      class="hero-bg w-full min-h-screen flex flex-col justify-end pb-24 pt-32 rounded-b-[30px]"
    >
      <div class="max-w-[1540px] mx-auto px-6 w-full">
        <div class="max-w-5xl flex flex-col gap-12">
          <div class="anim-1 font-display">
            <h1 class="anim-2 hero-title text-white text-8xl">
              Expert Advisory For<br />
              <span class="text-[#8C5A3C]">Smarter Farming</span>
            </h1>
          </div>

          <p class="anim-3 text-white/65 text-base leading-relaxed max-w-xl">
            Membantu agribisnis kopi Anda berkembang dengan
            <i>smart insights</i>, keahlian profesional, dan strategi
            operasional yang <i>sustainable</i>.
          </p>

          <div class="anim-4 flex flex-wrap gap-4 mt-6">
            <a href="#" class="btn-lime text-xl">Mulai Sekarang</a>
          </div>
        </div>
      </div>
    </section>

    <section class="max-w-[1540px] mx-auto px-6 mt-24">
      <div class="grid gap-8 md:gap-12 mb-10 md:px-4 items-end">
        <div class="md:col-span-7 flex flex-col items-start text-left">
          <div class="mb-5">
            <span
              class="badge-secondary font-display font-semibold text-xl px-4 py-1.5 rounded-full tracking-wide"
            >
              Our Achievement
            </span>
          </div>
          <h2
            class="font-display font-[800] text-black text-4xl md:text-[5.6rem] leading-tight"
          >
            Dedikasi Tanpa Henti<br />dan Pencapaian Mitra Kami
          </h2>
        </div>

        <div class="md:col-span-5 text-left md:pb-2">
          <p class="text-gray-500 font-body text-base leading-relaxed text-xl">
            Menghargai tradisi budidaya kopi sembari merangkul
            <i>modern innovations</i>. Platform kami menawarkan pendekatan
            seimbang yang memadukan metode <i>time-tested</i> dengan
            <i>cutting-edge technology</i> untuk kualitas terbaik.
          </p>
        </div>
      </div>

      <?php
      // Data statistik achievement
      $achievements = [
        [
          "value"       => "95%",
          "label"       => "Client Satisfaction",
          "description" => "Tingkat kepuasan tinggi dari mitra B2B maupun pelanggan *coffee subscription* kami di seluruh Indonesia.",
          "card_class"  => "card-1",
        ],
        [
          "value"       => "100+",
          "label"       => "Active Farmers",
          "description" => "Ratusan mitra petani kopi yang telah mengintegrasikan sistem <i>smart farming</i> di lahan mereka.",
          "card_class"  => "card-2",
        ],
        [
          "value"       => "400+",
          "label"       => "Wholesale Clients",
          "description" => "Mensuplai kebutuhan biji kopi konsisten untuk kafe, hotel, dan restoran secara nasional.",
          "card_class"  => "card-3",
        ],
        [
          "value"       => "100%",
          "label"       => "Freshly Roasted",
          "description" => "Pesanan Anda disangrai sesuai pesanan (<i>roast-to-order</i>) untuk memastikan fase <i>degassing</i> terbaik.",
          "card_class"  => "card-4",
        ],
      ];
      ?>

      <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-24 items-stretch"
      >
        <?php foreach ($achievements as $item): ?>
        <div
          class="card-hover <?php echo $item['card_class']; ?> rounded-3xl p-7 flex flex-col justify-between h-full gap-4<?php echo $item['card_class'] === 'card-2' ? ' shadow-lg' : ''; ?>"
        >
          <div>
            <p class="font-display font-extrabold text-4xl mb-1"><?php echo $item['value']; ?></p>
            <p class="font-display font-semibold text-base">
              <?php echo $item['label']; ?>
            </p>
          </div>
          <p class="text-sm leading-relaxed font-body">
            <?php echo $item['description']; ?>
          </p>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="max-w-[1540px] mx-auto px-6 mb-24">
      <div class="heading-anim text-right py-10 mb-6">
        <h2
          class="font-display font-extrabold text-[2.6rem] md:text-8xl text-[#3a3a3a] leading-tight"
        >
          Farming Solutions For Optimal<br />Yield and Sustainability
        </h2>
      </div>

      <?php
      // Data farm cards
      $farm_cards = [
        [
          "card_class" => "card-1",
          "img_src"    => "https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=800&q=80",
          "img_alt"    => "Coffee bean harvesting by hand",
          "label"      => "Precision Harvesting",
        ],
        [
          "card_class" => "card-2",
          "img_src"    => "https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=800&q=80",
          "img_alt"    => "Coffee bean processing and sorting",
          "label"      => "Data-Driven Processing",
        ],
        [
          "card_class" => "card-3",
          "img_src"    => "https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=800&q=80",
          "img_alt"    => "Roasted coffee beans closeup",
          "label"      => "Profile Roasting",
        ],
      ];
      ?>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <?php foreach ($farm_cards as $card): ?>
        <div
          class="farm-card <?php echo $card['card_class']; ?> relative rounded-2xl overflow-hidden aspect-[4/3] cursor-pointer"
        >
          <img
            src="<?php echo $card['img_src']; ?>"
            alt="<?php echo $card['img_alt']; ?>"
            class="w-full h-full object-cover"
          />
          <div
            class="card-bar absolute bottom-4 left-6 right-0 flex items-center justify-between px-4 py-3"
          >
            <span class="text-white text-sm font-body"><?php echo $card['label']; ?></span>
            <button class="see-more-btn">Lihat Detail</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="py-20 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div
          class="grid md:grid-cols-[5fr_7fr] gap-12 items-start justify-between"
        >
          <div class="anim-title pt-2 flex flex-col items-start text-left">
            <span
              class="font-display font-semibold tracking-widest text-xs uppercase text-amber-800 mb-2"
            >
              The Future of Coffee
            </span>
            <h2
              class="font-display font-extrabold text-[2rem] md:text-5xl lg:text-6xl leading-tight text-[#1e1e1e]"
            >
              Menghargai Tradisi,<br />
              Memimpin dengan<br />
              <i>Innovation.</i>
            </h2>
          </div>

          <div class="flex flex-col gap-8 pl-0 md:pl-8">
            <div>
              <h3 class="font-display font-bold text-xl text-[#1e1e1e] mb-3">
                Presisi <i>Micro-Climate</i> di Setiap MDPL
              </h3>
              <p
                class="text-base leading-relaxed font-body text-gray-700 text-justify"
              >
                Budidaya kopi kini bukan lagi sekadar tebakan cuaca. Ekosistem
                <i>smart farming</i> kami mengintegrasikan sensor tanah
                <i>real-time</i> dan pemantauan iklim berbasis AI. Kami membantu
                Anda melacak kelembapan, suhu sekitar, dan kebutuhan nutrisi
                secara akurat, memastikan setiap pohon kopi mendapatkan
                perawatan yang <i>tailored</i> di ketinggian berapapun.
              </p>
            </div>

            <div>
              <h3 class="font-display font-bold text-xl text-[#1e1e1e] mb-3">
                Konsistensi Panen & <i>Elevated Cup Scores</i>
              </h3>
              <p
                class="text-base leading-relaxed font-body text-gray-700 text-justify"
              >
                Didukung oleh <i>predictive analytics</i>, risiko gagal panen
                dan hama dapat dimitigasi lebih awal. Teknologi kami dirancang
                tidak hanya untuk efisiensi operasional, tetapi juga untuk
                mengunci <i>tasting notes</i> yang konsisten dan terus
                meningkatkan <i>cup scores</i> biji kopi Anda setiap musimnya.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-28 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="text-right mb-20">
          <span
            class="font-display text-xs uppercase tracking-widest text-amber-700 mb-3 block"
            >Cara Kerja Ekosistem Kami</span
          >
          <h2
            class="font-display font-extrabold text-4xl md:text-7xl text-[#1e1e1e] leading-tight"
          >
            Dari Kebun Menjadi Data,<br />Dalam 4 Langkah.
          </h2>
        </div>

        <?php
        // Data langkah-langkah proses
        $steps = [
          [
            "number"      => "01",
            "title"       => "Deploy Sensors",
            "description" => "Pasang sensor iklim dan tanah kami di berbagai zona kebun Anda untuk <i>data capture</i> 24/7.",
            "bg_class"    => "bg-[#C08552]",
          ],
          [
            "number"      => "02",
            "title"       => "Collect & Sync",
            "description" => "Data dialirkan secara <i>real-time</i> ke <i>cloud platform</i> kami dan diproses secara instan.",
            "bg_class"    => "bg-[#C08552]",
          ],
          [
            "number"      => "03",
            "title"       => "AI Analysis",
            "description" => "Model algoritma kami akan mendeteksi anomali, memprediksi risiko, dan merekomendasikan tindakan.",
            "bg_class"    => "bg-[#C08552]",
          ],
          [
            "number"      => "04",
            "title"       => "Act & Harvest",
            "description" => "Dapatkan <i>actionable insights</i> untuk intervensi lahan dan lakukan eksekusi panen yang lebih presisi.",
            "bg_class"    => "bg-[#8C5A3C]",
          ],
        ];
        ?>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 relative">
          <div
            class="hidden md:block absolute top-8 left-[12.5%] right-[12.5%] h-px bg-gray-300 z-0"
          ></div>

          <?php foreach ($steps as $step): ?>
          <div
            class="flex flex-col items-center text-center px-6 relative z-10"
          >
            <div
              class="w-16 h-16 rounded-full <?php echo $step['bg_class']; ?> text-white font-display font-extrabold text-2xl flex items-center justify-center mb-6"
            >
              <?php echo $step['number']; ?>
            </div>
            <h3 class="font-display font-bold text-lg text-[#1e1e1e] mb-2">
              <?php echo $step['title']; ?>
            </h3>
            <p class="font-body text-gray-500 text-sm leading-relaxed">
              <?php echo $step['description']; ?>
            </p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="py-20 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="grid md:grid-cols-[1fr_2fr] gap-12 items-start">
          <div class="anim-title pt-2">
            <h2
              class="font-display font-extrabold text-[2rem] md:text-6xl leading-tight text-[#1e1e1e]"
            >
              Pertanyaan yang Sering<br />Diajukan (FAQ)
            </h2>
          </div>

          <?php
          // Data FAQ
          $faqs = [
            [
              "question"   => "Apakah saya bisa berlangganan kopi secara bulanan (Subscription)?",
              "answer"     => "Tentu! Kami memiliki layanan <i>Coffee Subscription</i> di mana Anda akan menerima rotasi biji kopi <i>single origin</i> pilihan kami setiap bulannya, dikirim langsung ke rumah Anda tanpa biaya pengiriman tambahan.",
              "open"       => true,
              "anim_class" => "anim-faq-1",
            ],
            [
              "question"   => "Bagaimana cara bergabung menjadi mitra Wholesale (B2B)?",
              "answer"     => "Anda dapat mendaftar melalui halaman Services kami. Kami menyediakan <i>tiered pricing</i>, dukungan kalibrasi mesin rutin, dan dedikasi <i>account manager</i> untuk menyuplai kebutuhan kopi di kafe atau restoran Anda.",
              "open"       => false,
              "anim_class" => "anim-faq-2",
            ],
            [
              "question"   => "Apakah perangkat Smart Sensor Kit bisa dibeli secara terpisah?",
              "answer"     => "Ya, <i>Smart Sensor Node</i> kami tersedia di halaman Shop. Perangkat ini bersifat <i>plug-and-play</i> dan sudah termasuk lisensi untuk mengakses <i>dashboard analytics</i> kami.",
              "open"       => false,
              "anim_class" => "anim-faq-3",
            ],
            [
              "question"   => "Berapa lama estimasi waktu pengiriman untuk pesanan biji kopi?",
              "answer"     => "Kami menerapkan sistem <i>roast-to-order</i>. Pesanan yang masuk sebelum jam 14.00 akan disangrai di hari yang sama dan dikirimkan H+1 untuk menjamin kopi tiba dalam fase <i>degassing</i> yang paling optimal.",
              "open"       => false,
              "anim_class" => "anim-faq-4",
            ],
            [
              "question"   => "Apakah AGGRO menyediakan layanan Private Label Roasting?",
              "answer"     => "Ya, kami memfasilitasi pembuatan <i>house blend</i> khusus untuk merk Anda sendiri (<i>White Label</i>), mulai dari <i>sourcing</i> biji hijau (<i>green beans</i>) hingga pembuatan profil sangrai (<i>roast profile</i>).",
              "open"       => false,
              "anim_class" => "anim-faq-5",
            ],
          ];
          ?>

          <div class="flex flex-col gap-3">
            <?php foreach ($faqs as $faq): ?>
            <div
              class="faq-card faq-item <?php echo $faq['open'] ? 'open ' : ''; ?><?php echo $faq['anim_class']; ?> bg-white rounded-xl border border-gray-200 px-5 py-4"
              onclick="toggleFaq(this)"
            >
              <div class="flex items-<?php echo $faq['open'] ? 'start' : 'center'; ?> justify-between gap-4">
                <p
                  class="font-body font-<?php echo $faq['open'] ? 'semibold' : 'medium'; ?> text-[0.95rem] text-[#1e1e1e] leading-snug"
                >
                  <?php echo $faq['question']; ?>
                </p>
                <span class="faq-icon flex-shrink-0 <?php echo $faq['open'] ? 'mt-0.5' : ''; ?>">+</span>
              </div>
              <div class="faq-answer">
                <p
                  class="font-body text-[0.85rem] text-gray-500 leading-relaxed pt-3"
                >
                  <?php echo $faq['answer']; ?>
                </p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <footer class="py-11 px-6 md:px-10">
      <div class="max-w-[1540px] mx-auto">
        <div
          class="grid grid-cols-2 md:grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-x-8 gap-y-10"
        >
          <div class="col-span-2 md:col-span-1 flex flex-col gap-3">
            <h2
              class="logo text-[2.6rem] tracking-tight text-black leading-none"
            >
              AGGRO
            </h2>
            <p
              class="font-body text-[0.82rem] text-[#6b6b6b] leading-relaxed max-w-[200px]"
            >
              Menjaga tradisi, merangkul <i>modern innovations</i> untuk
              industri kopi yang lebih baik.
            </p>
          </div>

          <?php
          // Data footer links
          $footer_columns = [
            "Shop" => [
              ["label" => "All Coffee",        "href" => "#"],
              ["label" => "Subscriptions",      "href" => "#"],
              ["label" => "Smart Accessories",  "href" => "#"],
            ],
            "Company" => [
              ["label" => "About Us", "href" => "about.php"],
              ["label" => "Contact",  "href" => "#"],
              ["label" => "Careers",  "href" => "#"],
            ],
            "Services" => [
              ["label" => "Wholesale B2B",  "href" => "#"],
              ["label" => "Private Label",  "href" => "#"],
              ["label" => "Barista Training","href" => "#"],
            ],
            "Support" => [
              ["label" => "Shipping Policy", "href" => "#"],
              ["label" => "Help Center",     "href" => "#"],
              ["label" => "Return Policy",   "href" => "#"],
            ],
          ];
          ?>

          <?php foreach ($footer_columns as $heading => $links): ?>
          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">
              <?php echo $heading; ?>
            </h3>
            <ul class="flex flex-col gap-2">
              <?php foreach ($links as $link): ?>
              <li>
                <a href="<?php echo $link['href']; ?>" class="nav-link text-black font-body text-sm"
                  ><?php echo $link['label']; ?></a
                >
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </footer>

    <!-- Chat Bot Button Modal -->
    <button
      id="chatbot-trigger"
      class="fixed bottom-6 right-6 z-[60] w-14 h-14 bg-[#C08552] text-white rounded-full shadow-2xl flex items-center justify-center text-2xl hover:bg-[#8C5A3C] transition-all duration-300 hover:scale-110"
    >
      <i class="fa-solid fa-comment-dots"></i>
    </button>

    <!-- Chat Bot Modal -->
    <div
      id="chatbot-modal"
      class="fixed bottom-24 right-6 z-[60] w-[350px] bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col opacity-0 pointer-events-none transition-all duration-300 translate-y-4 scale-95 origin-bottom-right"
    >
      <div
        class="bg-[#1a1a1a] text-white px-5 py-4 flex justify-between items-center"
      >
        <div class="flex items-center gap-3">
          <div
            class="w-8 h-8 rounded-full bg-[#C08552] flex items-center justify-center shadow-inner"
          >
            <i class="fa-solid fa-robot text-sm"></i>
          </div>
          <div>
            <h3 class="font-display font-bold text-sm tracking-wide">
              AGGRO Assistant
            </h3>
            <p
              class="font-body text-[0.65rem] text-white/60 flex items-center gap-1.5 mt-0.5"
            >
              <span class="w-1.5 h-1.5 rounded-full bg-green-500 block"></span>
              Online
            </p>
          </div>
        </div>
        <button
          id="chatbot-close"
          class="text-white/50 hover:text-white transition-colors"
        >
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <div
        class="flex-1 p-5 overflow-y-auto h-[320px] bg-[#f5f0eb] flex flex-col gap-4"
      >
        <div class="flex gap-2">
          <div
            class="w-7 h-7 rounded-full bg-[#1a1a1a] text-white flex items-center justify-center flex-shrink-0 mt-1"
          >
            <i class="fa-solid fa-robot text-[0.6rem]"></i>
          </div>
          <div
            class="bg-white border border-gray-100 p-3.5 rounded-2xl rounded-tl-sm shadow-sm"
          >
            <p class="font-body text-[0.85rem] text-gray-700 leading-relaxed">
              Halo! 👋 Selamat datang di AGGRO. Ada yang bisa kami bantu seputar
              produk kopi atau kemitraan B2B hari ini?
            </p>
          </div>
        </div>

        <div class="flex flex-wrap gap-2 pl-9">
          <button
            class="font-body text-xs font-semibold text-[#C08552] border border-[#C08552] bg-white px-3 py-1.5 rounded-full hover:bg-[#C08552] hover:text-white transition-colors shadow-sm"
          >
            Tanya Subscription
          </button>
          <button
            class="font-body text-xs font-semibold text-[#C08552] border border-[#C08552] bg-white px-3 py-1.5 rounded-full hover:bg-[#C08552] hover:text-white transition-colors shadow-sm"
          >
            Suplai B2B (Wholesale)
          </button>
          <button
            class="font-body text-xs font-semibold text-[#C08552] border border-[#C08552] bg-white px-3 py-1.5 rounded-full hover:bg-[#C08552] hover:text-white transition-colors shadow-sm"
          >
            Status Pesanan
          </button>
        </div>
      </div>

      <div
        class="p-4 bg-white border-t border-gray-100 flex items-center gap-3"
      >
        <input
          type="text"
          placeholder="Ketik pesan Anda..."
          class="flex-1 font-body text-sm bg-[#fafaf8] border border-gray-200 rounded-full px-4 py-2.5 focus:outline-none focus:border-[#C08552] transition-colors"
        />
        <button
          class="w-10 h-10 rounded-full bg-[#1a1a1a] text-white flex items-center justify-center hover:bg-[#C08552] transition-colors flex-shrink-0 shadow-md"
        >
          <i class="fa-solid fa-paper-plane text-xs translate-x-[-1px]"></i>
        </button>
      </div>
    </div>
  </body>
  <script src="assests/js/toggle.js"></script>
  <script src="assests/js/chat-bot.js"></script>
  <script src="assests/js/navbar-scrollbar.js"></script>
</html>