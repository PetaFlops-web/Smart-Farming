<?php
require_once 'db_connect.php';
// product.php
$activePage = 'product';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product – AGGRO Smart Coffee Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assests/variables.css" />
    <link rel="stylesheet" href="assests/product.css" />
    <script src="assests/tailwind-config.js"></script>
</head>

<body>

    <nav class="fixed top-0 left-0 right-0 z-50 nav-fixed" id="navbar">
        <div class="max-w-[1540px] mx-auto px-6 w-full py-8 flex items-center justify-between">
            <a href="index.php" class="logo text-white text-4xl tracking-widest" style="letter-spacing:0.12em;">AGGRO</a>
            <div class="hidden md:flex items-center gap-8">
                <a href="services.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">Services</a>
                <a href="product.php" class="text-white text-xl font-medium transition-colors border-[#C08552] pb-0.5">Shop</a>
                <a href="about.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">About</a>
            </div>
            <a href="#" class="btn-outline text-xl">Cart (0)</a>
        </div>
    </nav>

    <section class="product-hero w-full min-h-screen flex flex-col justify-end pb-24 pt-36 rounded-b-[30px] overflow-hidden relative">
        <div class="grain-overlay absolute inset-0 pointer-events-none z-10"></div>

        <div class="absolute top-36 right-8 md:right-20 z-20 hero-badge anim-pill">
            <div class="hero-badge__inner">
                <div class="hero-badge__icon"><i class="fa-solid fa-leaf"></i></div>
                <div>
                    <p class="hero-badge__num">100%</p>
                    <p class="hero-badge__label">Organic Certified</p>
                </div>
            </div>
        </div>

        <div class="max-w-[1540px] mx-auto px-6 w-full relative z-20">
            <div class="flex flex-col gap-10">
                <div class="anim-1">
                    <p class="product-eyebrow mb-4">Our Products</p>
                    <h1 class="product-hero-title anim-2">
                        Grown Smart.<br />
                        Tasted <span class="text-[#C08552]">Better.</span>
                    </h1>
                </div>
                <div class="anim-3 flex flex-col md:flex-row gap-8 md:gap-24 items-start">
                    <p class="product-hero-sub max-w-md">
                        From sensor-guided green beans to precision-processed specialty lots — every product in our range carries a data story behind its cup.
                    </p>
                    <div class="flex flex-col gap-2">
                        <div class="divider-line"></div>
                        <p class="product-hero-sub max-w-sm">
                            Traceable. Sustainable. Scored above 84 — or we don't ship it.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 scroll-indicator">
            <div class="scroll-dot"></div>
        </div>
    </section>

    <section class="featured-product-section py-28 px-6">
        <div class="max-w-[1540px] mx-auto">

            <div class="featured-product-grid">
                <div class="fp-images reveal">
                    <div class="fp-img-main">
                        <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=900&q=80"
                            alt="Gayo Natural Process Coffee" />
                        <div class="fp-img-label">
                            <i class="fa-solid fa-location-dot mr-1.5 text-[#C08552]"></i>
                            Gayo Highlands, 1,400 MASL
                        </div>
                    </div>
                    <div class="fp-img-secondary">
                        <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500&q=80"
                            alt="Coffee processing" />
                    </div>
                    <div class="fp-score-badge">
                        <p class="fp-score-badge__num">89.5</p>
                        <p class="fp-score-badge__label">Cup Score</p>
                        <div class="fp-score-badge__stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                    </div>
                </div>

                <div class="fp-content reveal">
                    <span class="section-tag">Featured Product</span>
                    <h2 class="fp-title mt-3">Gayo Natural<br>Process — Lot 07A</h2>
                    <p class="fp-subtitle">Arabica · Sumatra · Natural</p>

                    <div class="fp-notes">
                        <p class="fp-notes__label"><i class="fa-solid fa-mug-saucer mr-2 text-[#C08552]"></i>Tasting Notes</p>
                        <div class="fp-notes__tags">
                            <span class="note-tag">Dark Chocolate</span>
                            <span class="note-tag">Caramelized Plum</span>
                            <span class="note-tag">Cedar</span>
                            <span class="note-tag">Vanilla Cream</span>
                        </div>
                    </div>

                    <div class="fp-specs">
                        <div class="fp-spec-row">
                            <span class="fp-spec-key"><i class="fa-solid fa-mountain-sun mr-2 text-[#C08552]"></i>Elevation</span>
                            <span class="fp-spec-val">1,380 – 1,420 MASL</span>
                        </div>
                        <div class="fp-spec-row">
                            <span class="fp-spec-key"><i class="fa-solid fa-flask mr-2 text-[#C08552]"></i>Process</span>
                            <span class="fp-spec-val">Natural / Sun-dried</span>
                        </div>
                        <div class="fp-spec-row">
                            <span class="fp-spec-key"><i class="fa-solid fa-calendar mr-2 text-[#C08552]"></i>Harvest</span>
                            <span class="fp-spec-val">June – August 2024</span>
                        </div>
                        <div class="fp-spec-row">
                            <span class="fp-spec-key"><i class="fa-solid fa-box mr-2 text-[#C08552]"></i>Stock</span>
                            <span class="fp-spec-val">Only 24 Bags Left</span>
                        </div>
                        <div class="fp-spec-row">
                            <span class="fp-spec-key"><i class="fa-solid fa-certificate mr-2 text-[#C08552]"></i>Cert.</span>
                            <span class="fp-spec-val">Rainforest Alliance · Organic</span>
                        </div>
                    </div>

                    <div class="fp-pricing">
                        <div>
                            <span class="fp-price">Rp 485.000</span>
                            <span class="fp-price-unit">/ 250g</span>
                        </div>
                        <div class="fp-price-alt">Rp 1.750.000 / 1kg</div>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="#" class="btn-primary-brown">
                            <i class="fa-solid fa-cart-shopping mr-2"></i> Add to Cart
                        </a>
                        <a href="#" class="btn-ghost-brown">
                            <i class="fa-solid fa-rotate mr-2"></i> Subscribe & Save 10%
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-28 px-6 bg-[#1a1a1a]">
        <div class="max-w-[1540px] mx-auto">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                <div>
                    <span class="section-tag-light">Product Catalog</span>
                    <h2 class="section-heading-light mt-2">Shop by<br>Category.</h2>
                </div>
                <div class="cat-tabs" id="catTabs">
                    <button class="cat-tab cat-tab--active" data-cat="all">All Products</button>
                    <button class="cat-tab" data-cat="roasted">Roasted</button>
                    <button class="cat-tab" data-cat="green">Green Bean</button>
                    <button class="cat-tab" data-cat="extract">Extract</button>
                    <button class="cat-tab" data-cat="kit">Smart Accessories</button>
                </div>
            </div>

            <div class="product-grid" id="productGrid">

                <?php
                $sql = "SELECT * FROM produk";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $cat = htmlspecialchars($row['kategori']);
                        $nama = htmlspecialchars($row['nama_produk']);
                        $harga = number_format($row['harga'], 0, ',', '.');
                        $unit = htmlspecialchars($row['unit']);
                        $score = $row['cup_score'];
                        $gambar = htmlspecialchars($row['gambar']);
                        
                        // Parse description to get category string and tasting notes
                        $desc = $row['deskripsi'];
                        $cat_str = $desc;
                        $notes = [];
                        if (strpos($desc, 'Tasting Notes:') !== false) {
                            $parts = explode('Tasting Notes:', $desc);
                            $cat_str = trim($parts[0], " .");
                            $notes_str = trim($parts[1]);
                            $notes = array_map('trim', explode(',', $notes_str));
                        } else if (strpos($desc, '.') !== false) {
                            $parts = explode('.', $desc, 2);
                            $cat_str = trim($parts[0]);
                            $notes_str = trim($parts[1]);
                            $notes = array_map('trim', explode(',', $notes_str));
                        }
                ?>
                <div class="prod-card reveal" data-cat="<?php echo $cat; ?>">
                    <div class="prod-card__img-wrap">
                        <img src="<?php echo $gambar; ?>" alt="<?php echo $nama; ?>" class="prod-card__img" />
                        <div class="prod-card__overlay">
                            <a href="#" class="prod-card__quick-btn"><i class="fa-solid fa-eye mr-1.5"></i> Quick View</a>
                        </div>
                    </div>
                    <div class="prod-card__body">
                        <div class="prod-card__category"><?php echo htmlspecialchars($cat_str); ?></div>
                        <h3 class="prod-card__name"><?php echo $nama; ?></h3>
                        <div class="prod-card__notes">
                            <?php foreach($notes as $note): if($note): ?>
                            <span class="prod-note"><?php echo htmlspecialchars(trim($note, ". ")); ?></span>
                            <?php endif; endforeach; ?>
                        </div>
                        <div class="prod-card__footer">
                            <div>
                                <p class="prod-card__price">Rp <?php echo $harga; ?></p>
                                <p class="prod-card__unit"><?php echo $unit; ?></p>
                            </div>
                            <div class="prod-card__score-wrap <?php echo !$score ? 'prod-card__score-wrap--alt' : ''; ?>">
                                <?php if($score): ?>
                                <i class="fa-solid fa-star text-[#C08552] text-xs"></i>
                                <span class="prod-card__score"><?php echo number_format($score, 1); ?></span>
                                <?php else: ?>
                                <i class="fa-solid fa-shield-check text-[#C08552] text-xs"></i>
                                <span class="prod-card__score">Certified</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <form action="cart.php" method="POST" class="mt-4">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="prod-card__add-btn w-full">
                                <i class="fa-solid fa-cart-shopping mr-2"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p class='text-white'>Belum ada produk.</p>";
                }
                ?>

            </div>

            <div class="text-center mt-14">
                <button class="btn-load-more">
                    Load More Products <i class="fa-solid fa-chevron-down ml-2"></i>
                </button>
            </div>

        </div>
    </section>

    <section class="trace-section py-28 px-6">
        <div class="max-w-[1540px] mx-auto">

            <div class="text-center mb-20">
                <span class="section-tag">Quality Guarantee</span>
                <h2 class="section-heading-dark mt-2">Taste the<br>Data Difference.</h2>
                <p class="font-body text-gray-500 text-base mt-5 max-w-lg mx-auto">
                    Scan the QR on any AGGRO product to see the journey of your coffee—from the exact soil conditions to its certified cup score.
                </p>
            </div>

            <div class="trace-steps">
                <div class="trace-step reveal">
                    <div class="trace-step__img-wrap">
                        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600&q=80" alt="Farm origin" />
                        <div class="trace-step__num">01</div>
                    </div>
                    <h3 class="trace-step__title">Single Origin Sourced</h3>
                    <p class="trace-step__body">Ketahui langsung dari blok kebun mana kopi Anda berasal, beserta profil petaninya.</p>
                </div>

                <div class="trace-connector"><i class="fa-solid fa-arrow-right"></i></div>

                <div class="trace-step reveal">
                    <div class="trace-step__img-wrap">
                        <img src="https://images.unsplash.com/photo-1455462027176-af8c23a7e9f4?w=600&q=80" alt="Sensor data" />
                        <div class="trace-step__num">02</div>
                    </div>
                    <h3 class="trace-step__title">Precision Cultivation</h3>
                    <p class="trace-step__body">Sensor pintar kami memastikan ceri kopi dipanen pada tingkat kematangan dan kelembaban tanah yang sempurna.</p>
                </div>

                <div class="trace-connector"><i class="fa-solid fa-arrow-right"></i></div>

                <div class="trace-step reveal">
                    <div class="trace-step__img-wrap">
                        <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=600&q=80" alt="Harvest & process" />
                        <div class="trace-step__num">03</div>
                    </div>
                    <h3 class="trace-step__title">Masterful Processing</h3>
                    <p class="trace-step__body">Diproses secara higienis dengan data fermentasi yang terukur untuk menjamin konsistensi rasa terbaik.</p>
                </div>

                <div class="trace-connector"><i class="fa-solid fa-arrow-right"></i></div>

                <div class="trace-step reveal">
                    <div class="trace-step__img-wrap">
                        <img src="https://images.unsplash.com/photo-1512568400610-62da28bc8a13?w=600&q=80" alt="Cup score report" />
                        <div class="trace-step__num">04</div>
                    </div>
                    <h3 class="trace-step__title">SCA Certified Cup</h3>
                    <p class="trace-step__body">Disertai dengan skor cupping resmi dan profil rasa (tasting notes) untuk panduan seduhan Anda.</p>
                </div>
            </div>

            <div class="text-center mt-16">
                <a href="#" class="btn-primary-brown">
                    <i class="fa-solid fa-qrcode mr-2"></i> Try a Sample Trace
                </a>
            </div>
        </div>
    </section>

    <section class="py-28 px-6 bg-[#f5f0eb]">
        <div class="max-w-[1540px] mx-auto">

            <div class="mb-16">
                <span class="section-tag">Compare</span>
                <h2 class="section-heading-dark mt-2">Find Your<br>Perfect Lot.</h2>
            </div>

            <div class="compare-table-wrap">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th class="compare-table__th compare-table__th--first">Product</th>
                            <th class="compare-table__th">Origin</th>
                            <th class="compare-table__th">Process</th>
                            <th class="compare-table__th">Cup Score</th>
                            <th class="compare-table__th">Roast Level</th>
                            <th class="compare-table__th">Price / kg</th>
                            <th class="compare-table__th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="compare-table__row">
                            <td class="compare-table__td compare-table__td--name">
                                <div class="compare-td-img">
                                    <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=80&q=80" alt="" />
                                </div>
                                Gayo Natural Lot 07A
                            </td>
                            <td class="compare-table__td">Sumatra</td>
                            <td class="compare-table__td"><span class="compare-badge compare-badge--natural">Natural</span></td>
                            <td class="compare-table__td compare-table__td--score">89.5 ★</td>
                            <td class="compare-table__td">Medium</td>
                            <td class="compare-table__td">Rp 485.000</td>
                            <td class="compare-table__td"><a href="#" class="compare-order-btn">Add to Cart</a></td>
                        </tr>
                        <tr class="compare-table__row compare-table__row--featured">
                            <td class="compare-table__td compare-table__td--name">
                                <div class="compare-td-img">
                                    <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=80&q=80" alt="" />
                                </div>
                                Flores Bajawa Washed
                            </td>
                            <td class="compare-table__td">Flores</td>
                            <td class="compare-table__td"><span class="compare-badge compare-badge--washed">Washed</span></td>
                            <td class="compare-table__td compare-table__td--score">87.5 ★</td>
                            <td class="compare-table__td">Light–Medium</td>
                            <td class="compare-table__td">Rp 310.000</td>
                            <td class="compare-table__td"><a href="#" class="compare-order-btn">Add to Cart</a></td>
                        </tr>
                        <tr class="compare-table__row">
                            <td class="compare-table__td compare-table__td--name">
                                <div class="compare-td-img">
                                    <img src="https://images.unsplash.com/photo-1498804103079-a6351b050096?w=80&q=80" alt="" />
                                </div>
                                Java Ijen Robusta
                            </td>
                            <td class="compare-table__td">Java</td>
                            <td class="compare-table__td"><span class="compare-badge compare-badge--natural">Natural</span></td>
                            <td class="compare-table__td compare-table__td--score">83.0 ★</td>
                            <td class="compare-table__td">Dark</td>
                            <td class="compare-table__td">Rp 145.000</td>
                            <td class="compare-table__td"><a href="#" class="compare-order-btn">Add to Cart</a></td>
                        </tr>
                        <tr class="compare-table__row">
                            <td class="compare-table__td compare-table__td--name">
                                <div class="compare-td-img">
                                    <img src="assests/img/jepdi.jpg" alt="" />
                                </div>
                                AGGRO Signature Espresso
                            </td>
                            <td class="compare-table__td">Blend</td>
                            <td class="compare-table__td"><span class="compare-badge compare-badge--blend">Blend</span></td>
                            <td class="compare-table__td compare-table__td--score">85.0 ★</td>
                            <td class="compare-table__td">Medium–Dark</td>
                            <td class="compare-table__td">Rp 780.000</td>
                            <td class="compare-table__td"><a href="#" class="compare-order-btn">Add to Cart</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="cta-section py-28 px-6">
        <div class="max-w-[1540px] mx-auto">
            <div class="cta-inner reveal">
                <div class="cta-bg-art"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
                    <div>
                        <p class="font-body text-[#C08552] text-xs uppercase tracking-widest mb-3 font-semibold">Coffee Subscriptions</p>
                        <h2 class="font-display font-extrabold text-white text-4xl md:text-6xl leading-tight">
                            Never Run Out<br>of Great Coffee.
                        </h2>
                        <p class="font-body text-white/60 text-base mt-4 max-w-sm">
                            Berlangganan kopi favorit Anda setiap bulan. Hemat 10%, nikmati pengiriman gratis, dan dapatkan akses eksklusif ke rilis produk terbaru kami.
                        </p>
                    </div>
                    <div class="flex flex-col gap-4 flex-shrink-0">
                        <a href="#" class="btn-primary-lime">
                            <i class="fa-solid fa-rotate mr-2"></i> Mulai Berlangganan
                        </a>
                        <a href="#" class="text-center text-white/60 font-body text-sm hover:text-white transition-colors">
                            <i class="fa-solid fa-store mr-2"></i> Lihat Opsi Wholesale (B2B)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-11 px-6 md:px-10">
        <div class="max-w-[1540px] mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-x-8 gap-y-10">
                <div class="col-span-2 md:col-span-1 flex flex-col gap-3">
                    <h2 class="logo text-[2.6rem] tracking-tight text-black leading-none">AGGRO</h2>
                    <p class="font-body text-[0.82rem] text-[#6b6b6b] leading-relaxed max-w-[200px]">
                        Honor the traditions of farming while embracing modern innovations.
                    </p>
                    <div class="flex gap-4 mt-2">
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <h3 class="font-body font-semibold text-[0.9rem] text-black">Shop</h3>
                    <ul class="flex flex-col gap-2">
                        <li><a href="#" class="nav-link-footer">All Coffee</a></li>
                        <li><a href="#" class="nav-link-footer">Subscriptions</a></li>
                        <li><a href="#" class="nav-link-footer">Smart Accessories</a></li>
                    </ul>
                </div>
                <div class="flex flex-col gap-3">
                    <h3 class="font-body font-semibold text-[0.9rem] text-black">Company</h3>
                    <ul class="flex flex-col gap-2">
                        <li><a href="about.php" class="nav-link-footer">About</a></li>
                        <li><a href="#" class="nav-link-footer">Contact us</a></li>
                        <li><a href="#" class="nav-link-footer">Careers</a></li>
                    </ul>
                </div>
                <div class="flex flex-col gap-3">
                    <h3 class="font-body font-semibold text-[0.9rem] text-black">Support</h3>
                    <ul class="flex flex-col gap-2">
                        <li><a href="#" class="nav-link-footer">Shipping Policy</a></li>
                        <li><a href="#" class="nav-link-footer">Help center</a></li>
                        <li><a href="#" class="nav-link-footer">Return Policy</a></li>
                    </ul>
                </div>
                <div class="flex flex-col gap-3">
                    <h3 class="font-body font-semibold text-[0.9rem] text-black">Traceability</h3>
                    <ul class="flex flex-col gap-2">
                        <li><a href="#" class="nav-link-footer">Scan QR Code</a></li>
                        <li><a href="#" class="nav-link-footer">Partner Farms</a></li>
                        <li><a href="#" class="nav-link-footer">Our Standards</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="font-body text-xs text-gray-400">© 2026 AGGRO Agritech. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="font-body text-xs text-gray-400 hover:text-gray-600 transition-colors">Privacy Policy</a>
                    <a href="#" class="font-body text-xs text-gray-400 hover:text-gray-600 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="assests/js/navbar-scrollbar.js"></script>
    <script>
        // Category filter
        const tabs = document.querySelectorAll('.cat-tab');
        const cards = document.querySelectorAll('.prod-card');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('cat-tab--active'));
                tab.classList.add('cat-tab--active');

                const cat = tab.dataset.cat;
                cards.forEach(card => {
                    const match = cat === 'all' || card.dataset.cat === cat;
                    card.style.display = match ? '' : 'none';
                    if (match) {
                        card.style.animation = 'none';
                        card.offsetHeight; // reflow
                        card.style.animation = 'prodCardIn 0.4s ease forwards';
                    }
                });
            });
        });
    </script>
</body>

</html>